<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatBot;
use App\Models\ChatSesi;
use App\Models\User;
use App\Services\Pushers;

class LiveChatController extends Controller
{
    protected $notify;
    public function __construct() {
        $this->notify = new Pushers('chat-channel', 'Chat');
    }

    public function index() {
        $bots = ChatBot::latest()->get();
        $sesi_chat = ChatSesi::with(['chats', 'user' => function($query) {
            $query->with(['profile']);
        }])->latest()->get();
        $data = [
            'bots' => $bots,
            'sesi' => $sesi_chat
        ];

        return view('admin-pages.live-chat', $data);
    }
    public function botStore(Request $request) {
        $validator = \Validator::make($request->all(), [
            'bot_judul' => ['nullable'],
            'bot_keyword' => ['required'],
            'bot_prioritas' => ['nullable'],
            'bot_chat' => ['required'],
        ]);
        // return;
        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $chat_bot = ChatBot::create([
            'judul' => $input['bot_judul'],
            'keyword' => $input['bot_keyword'],
            'prioritas' => $input['bot_prioritas'],
            'chat' => $input['bot_chat'],
        ]);

        return redirect(route('admin.livechat.index'))->with('notes', ['text' => 'Text Bot ditambah!']);
    }
    public function botUpdate(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
            'bot_judul' => ['nullable'],
            'bot_keyword' => ['required'],
            'bot_prioritas' => ['nullable'],
            'bot_chat' => ['required'],
        ]);
        // return;
        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $chat_bot = ChatBot::findOrFail($id)->update([
            'judul' => $input['bot_judul'],
            'keyword' => $input['bot_keyword'],
            'prioritas' => $input['bot_prioritas'],
            'chat' => $input['bot_chat'],
        ]);

        return redirect(route('admin.livechat.index'))->with('notes', ['text' => 'Bot Diubah!']);
    }
    public function botDestroy(Request $request, $id) {
        $chat_bot = ChatBot::findOrFail($id);
        $chat_bot->delete();
        return redirect(route('admin.livechat.index'))->with('notes', ['text' => 'Bot Dihapus!']);
    }
    public function chatwithBot(Request $request) {
        $validator = \Validator::make($request->all(), [
            'chat' => ['required'],
        ]);
        // return;
        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $user = auth()->user();

        $bot = ChatBot::where('keyword', 'like', '%'.$input['chat'].'%')->first();

        // $new_chat['conversations'] = $old_conversation;

        // session(['chats' => $new_chat]);

        return response()->Json(['msg' => $bot ? $bot->chat: 'Maaf kak kode tidak ditemukan. mohon hubungi costumer service']);
    }
    public function searchOnlineCs(Request $request) {

        $user = auth()->user();
        if($user) {
            $cs = User::whereHas('roles', function($query) {
                $query->where('tipe', 2);
            })->whereOnline(1)->first();
    
            if($cs) {
                $check_if_session_exist = ChatSesi::where('id_user', $user->id_user)->first();
                if(!$check_if_session_exist) {
                    $sesi = ChatSesi::create([
                        'id_user' => $user->id_user,
                        'id_admin' => $cs->id_user,
                        'status' => 1
                    ]);
                    return response()->json(['msg' => '', 'status' => 0, 'found' => true, 'cs' => $cs]);
                }
                return response()->json(['msg' => '', 'status' => -1, 'found' => false, 'cs' => null]);
            }    
            return response()->json(['msg' => 'Maaf costumer service sedang offline. coba beberapa saat lagi.', 'found' => false, 'cs' => $cs]);
        }
        
        return response()->json(['msg' => 'Silahkan login untuk kontak dengan Cs', 'found' => false, 'cs' => null]);
    }
    public function connectToUser(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
        ]);
        // return;
        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::find($input['id_sesi']);
        $sesi->status = 2;
        $sesi->save();

        $this->notify->send(['msg' => 'Connected', 'type' => 'connection_info', 'sesi' => $sesi->toJson()]);

        return response()->json(['msg' => 'connected', 'status' => 1]);
    }
    public function disconnectToUser(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::find($input['id_sesi']);
        $sesi->status = 1;
        $sesi->save();
        $sesi->hapus();

        $this->notify->send(['msg' => 'Sesi Berakhir.', 'type' => 'connection_info']);

        return response()->json(['msg' => 'disconnected', 'status' => 1]);
    }
    public function chatWithUser(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
            'chat' => ['required'],
        ]);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::find($input['id_sesi']);

        $sesi->chats()->create([
            'chat' => $input['chat'],
            'pengirim' => auth()->user()->id_user
        ]);

        $this->notify->send(['msg' => $input['chat'], 'type' => 'receive', 'sesi' => $sesi->toJson()]);

        return response()->json(['msg' => '']);
    }
    public function chatWithCs(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
            'chat' => ['required'],
        ]);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::find($input['id_sesi']);

        $sesi->chats()->create([
            'chat' => $input['chat'],
            'pengirim' => auth()->user()->id_user
        ]);

        return response()->json(['msg' => '']);
    }
}
