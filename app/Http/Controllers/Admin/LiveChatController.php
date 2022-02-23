<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Services\Pushers;
use Pusher\Pusher;

use App\Models\ChatBot;
use App\Models\ChatSesi;
use App\Models\User;


class LiveChatController extends Controller
{
    // define pusher variabel
    // protected $notify;
    protected $pusher;
    public function __construct() {
        // $this->notify = new Pushers('chat-channel', 'Chat');
        $this->pusher = new Pusher(
			config('pusher.APP_KEY'),
			config('pusher.APP_SECRET'),
			config('pusher.APP_ID'), 
			[
                'cluster' => config('pusher.APP_CLUSTER'),
                'encrypted' => config('pusher.encrypted')
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

    // crud chat bot admin 
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

    // ngechat dengan bot di halaman user
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

    // request untuk chat dengan cs
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

    // admin konek chat
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
                'data' => $chat
            ]);
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
        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', [
            'msg' => 'Connected.', 'event' => 'chat', 
            'data' => $chat
        ]);

        return response()->json(['msg' => 'connected', 'status' => 1, 'data' => $chat]);
    }

    // admin diskonek chat
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

    // admin chat ke user
    public function chatWithUser(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id_sesi' => ['required'],
            'chat' => ['required'],
        ]);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        endif;

        $input = $validator->validated();

        $sesi = ChatSesi::with(['chats', 'user' => function($query) {
            $query->with(['profile']);
        }])->where('id_chat_sesi', $input['id_sesi'])->first();

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

        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', [
            'msg' => $input['chat'],
            'timestamp' => date("Y-m-d H:i:s"), 
            'event' => 'chat', 
            'data' => $chat
        ]);

        return response()->json(['msg' => '']);
    }

    // user chat ke admin
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

        $sesi = ChatSesi::with(['chats', 'user' => function($query) {
            $query->with(['profile']);
        }])->where('id_chat_sesi', $input['id_sesi'])->first();

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

        $this->pusher->trigger('private-chat.'.$sesi->id_chat_sesi, 'App\\Events\\Chat', [
            'msg' => $input['chat'], 
            'timestamp' => now(), 
            'event' => 'chat', 
            'data' => $chat
        ]);

        return response()->json(['msg' => 'msg sent']);
    }

    // admin buka chat
    public function markAsReadChat(Request $request) {
        $validated_input = $request->only(['id_chat_sesi']);
        $sesi = ChatSesi::where('id_chat_sesi', $validated_input['id_chat_sesi'])->first();
        if($sesi) {
            $sesi->chats()->where('pengirim', $sesi->id_user)->update([
                'read_at' => now()
            ]);
        }
        return response()->json(['msg' => '']);
    }

    // test
    public function testBroadcast($id) {
        $this->pusher->trigger('private-chat.'.$id, 'App\\Events\\Chat', ['msg' => 'success dong']);
    }
}
