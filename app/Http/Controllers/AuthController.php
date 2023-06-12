<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnableMemberRequest;
use App\Models\AuthLevel;
use App\Models\User;
use App\Models\UserAdvance;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dashboard()
    {

        return view('dashboard');
    }
    public function authLevel2()
    {

        return view('authlevel.member_rigister');
    }
    public function authLevel2Store(EnableMemberRequest $request)
    {
        $user = User::find(Auth::id());
        $user->identify = $request->identify;
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->tel = $request->tel;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->save();
        UserAdvance::create([
            'user_id' => Auth::id(),
            'country_id' => $request->userCountryId,
            'city_id' => $request->userCityId,
            'town_id' => $request->userTownId,
            'road_id' => $request->userRoadId,
            'phone_code_id' => $request->userPCountryId,
            'local_phone_code_id' => $request->userPLocalId,
            'auth_level_id' => AuthLevel::where('title', '會員功能啟用')->first()->id,
        ]);

        return view('dashboard');
    }

    //   $column = ['username', 'first_name', 'last_name', 'gender', 'identify', 'birthday', 'tel', 'mobile', 'post_id', 'address'];
    //   $user = User::find(Auth::id());

    //   foreach ($column as $key) {
    //       if ($key == 'tel') {
    //           $user->{$key} = '(' . $request->pZone . ')' . $request->tel;
    //       } else {
    //           $user->{$key} = $request->{$key};
    //       }
}
