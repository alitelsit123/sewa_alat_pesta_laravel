<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    public function showProfilePage($slug) {
        $user = User::where('email', $slug)->orWhereHas('profile', function($q) use ($slug) {
            $q->where('id_profile', $slug);
        })->first();

        if(!$user) {
            return redirect('/');
        }

        $data = [
            'user' => $user,
            'is_me' => auth()->user() ? auth()->user()->id_user == $user->id_user: false, 
        ];
        return view('public-pages.profile', $data);
    }
    public function update(Request $request, $slug){
        
        $validated_input = $request->except(['_token', '_method']);
        $user = auth()->user();

        $alamats = collect($validated_input)->filter(function($item,$index) {
            return \str_contains($index, 'alamat_');
        });
        $profile = $user->profile();

        $alamats->map(function($item, $index) use ($profile, $validated_input) {
            $id_address = \str_replace('alamat_', '', $index);
            $map_lat = $validated_input['map_lat_'.$id_address];
            $map_lng = $validated_input['map_lng_'.$id_address];
            // echo 'lat: '.$map_lat.' lng: '.$map_lng.'<br />';
            $profile->first()->addresses()->whereId_address((int)$id_address)->update([
                'alamat' => $item,
                'lat' => $map_lat,
                'lng' => $map_lng,
            ]);    
        });
        // return;

        $profile->update([
            'nama' => $validated_input['profile_nama'],
            'telepon' => $validated_input['profile_telepon'],
            'nik' => $validated_input['profile_nik'],
            'tanggal_lahir' => $validated_input['profile_tanggal_lahir'],
            'kodepos' => $validated_input['profile_kodepos'],
            'pekerjaan' => $validated_input['profile_pekerjaan'],
            'alamat' => '',
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
    public function addNewAddress($slug) {
        $user = auth()->user();
        $profile = $user->profile;
        $address = new \App\Models\Address();
        $address->id_profile = $profile->id_profile;
        $address->save();
        session()->flash('address_added', 'Address_added');
        return redirect()->back();
    }
    public function removeAddress(Request $request, $slug, $id) {
        $user = auth()->user();
        $address = $user->profile->addresses()->whereId_address($id)->first();
        if($address) {
            $address->delete();
        }
        return redirect()->back()->with(['msg_success' => 'Alamat Dihapus']);
    }
}
