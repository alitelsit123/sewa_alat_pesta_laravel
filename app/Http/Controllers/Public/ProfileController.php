<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    public function showProfilePage($slug) {
        $user = User::where('email', $slug)->orWhereHas('profile', function($q) use ($slug) {
            $q->where('id_profile', $slug);
        })->firstOrFail();

        $data = [
            'user' => $user,
            'is_me' => auth()->user() ? auth()->user()->id_user == $user->id_user: false, 
        ];
        return view('public-pages.profile', $data);
    }
    public function update(Request $request, $slug){
        $validated_input = $request->except(['_token', '_method']);
        $user = auth()->user();
        $user->profile()->update([
            'nama' => $validated_input['profile_nama'],
            'telepon' => $validated_input['profile_telepon'],
            'tanggal_lahir' => $validated_input['profile_tanggal_lahir'],
            'alamat' => $validated_input['profile_alamat'],
            'kodepos' => $validated_input['profile_kodepos'],
            'pekerjaan' => $validated_input['profile_pekerjaan'],
        ]);

        return back()->with(['msg_success' => 'Biodata di update']);
    }
    public function updatePhoto(Request $request, $slug){
        $validator = \Validator::make($request->all(), [
            'photo' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        if($validator->fails()) {
            return back()->with('msg_error', 'Gagal upload gambar')->withErrors($validator);
        }

        if($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'mita_user_img_'.time().uniqid().'.'.$extension;
            
            if(!$file->storeAs('users', $filename, 'upload')) {
                return back()->with('msg_error', 'Gagal upload gambar');
            }
            $user = auth()->user();
            $user->profile()->update([
                'photo' => $filename,
            ]);
        }

        return back()->with(['msg_success' => 'Biodata di update']);
    }
}
