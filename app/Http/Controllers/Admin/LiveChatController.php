<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Pushers;
use Pusher\Pusher;

use App\Models\ChatBot;
use App\Models\ChatSesi;
use App\Models\User;


class LiveChatController extends Controller
{
    protected $notify;
    protected $pusher;
    public function __construct() {
        $this->notify = new Pushers('chat-channel', 'Chat');
        $this->pusher = new Pusher(
			env('PUSHER_APP_KEY'),
			env('PUSHER_APP_SECRET'),
			env('PUSHER_APP_ID'), 
			[
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            ]
		);
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
                    $retreive_sesi = ChatSesi::with(['user' => function($query) {
                        $query->with(['profile']);
                    }])->where('id_chat_sesi', $sesi->id_chat_sesi)->first();

                    $chat = [
                        'type' => 'user_request',
                        'sesi' => $retreive_sesi,
                    ];

                    $this->pusher->trigger('private-chat-request.'.$cs->id_user, 'App\\Events\\Chat', ['msg' => 'Request chat from'.$retreive_sesi->user->email, 'event' => 'chat', 'data' => $chat]);

                    return response()->json(['msg' => '', 'status' => 0, 'found' => true, 'sesi' => $sesi]);
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
        $chat = [
            'type' => 'connected', 
            'connection_status' => 1,
            'sesi' => $sesi,
        ];

        if($request->has('reject')) {
            $chat['type'] = 'rejected';
            $chat['connection_status'] = 0;
            $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', [
                'msg' => 'Sesi ditolak. Admin sibuk. Silahkan hubungi beberapa saat.', 
                'event' => 'chat', 
                'data' => $chat]);
            $sesi->hapus();
            return response()->json(['msg' => 'Rejected.', 'status' => 1, 'data' => $chat]);
        } else if($request->has('wait')) {
            $chat['type'] = 'waited';
            $chat['connection_status'] = 1;
            $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', ['msg' => 'Mohon tunggu sebentar.', 'event' => 'chat', 'data' => $chat]);
            return response()->json(['msg' => 'Menunggu ...', 'status' => 1, 'data' => $chat]);
        }
        
        $sesi->status = 2;
        $sesi->save();

        $chat['sesi'] = $sesi;
        $chat['type'] = 'connected';
        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', ['msg' => 'Connected.', 'event' => 'chat', 'data' => $chat]);

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

        $chat = [
            'type' => 'disconnected', 
            'connection_status' => 0,
            'sesi' => $sesi,
        ];

        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', ['msg' => 'Sesi Berakhir.', 'event' => 'chat', 'data' => $chat]);

        $sesi->hapus();

        return response()->json(['msg' => 'disconnected', 'status' => 1, 'data' => $chat]);
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

        $chat = [
            'type' => 'received', 
            'connection_status' => 1,
            'sesi' => $sesi,
            'receiver' => $sesi->id_user
        ];

        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', ['msg' => $input['chat'], 'event' => 'chat', 'data' => $chat]);

        return response()->json(['msg' => '']);
    }
    public function chatWithCs(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
            'chat' => ['required'],
            'user' => ['required'],
        ]);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::find($input['id_sesi']);

        if($sesi->status == 1) {
            return response()->json(['msg' => 'not connected']);
        }

        $sesi->chats()->create([
            'chat' => $input['chat'],
            'pengirim' => auth()->user()->id_user
        ]);

        $chat = [
            'type' => 'received', 
            'connection_status' => 1,
            'sesi' => $sesi,
            'receiver' => $sesi->id_admin
        ];

        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', ['msg' => $input['chat'], 'event' => 'chat', 'data' => $chat]);

        return response()->json(['msg' => 'msg sent']);
    }
    public function authorizeUser(Request $request) {
        if (!auth()->check()) {
            return response('Forbidden', 403);
        }
        echo $this->pusher->socket_auth(
            $request->input('channel_name'), 
            $request->input('socket_id')
        );
        // return true;
    }
    public function testBroadcast($id) {
        $this->pusher->trigger('private-chat.'.$id, 'App\\Events\\Chat', ['msg' => 'success dong']);
    }
}
