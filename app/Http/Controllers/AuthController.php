<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnableMemberRequest;
use App\Models\AuthLevel;
use App\Models\User;
use App\Models\UserAdvance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function dashboard()
    {
        if (session('event') == 'authLevel2') {
            if (session('status') == 'success') {
                // flash('功能成功開通!!')->overlay(); //對話框
                flash('功能成功開通!!')->success(); //綠色框
            } else if (session('status') == 'noNeed') {
                // flash('您已開通，無需申請')->overlay(); //對話框
                flash('您已開通，無需申請')->success(); //綠色框
            }
            session(['event' => 'nan', 'status' => 'nan']);
        }
        $user = User::find(Auth::id());
        $name = $user->name;
        $userAdvance = UserAdvance::where('user_id', Auth::id())->get();
        $today = Carbon::now();
        $date = $today->toDateString();
        $time = $today->toTimeString();
        return view('dashboard', compact(['userAdvance', 'date', 'time', 'name']));
    }
    public function authLevel2()
    {
        if (session('event') == 'nan') {
            return view('authlevel.member_rigister');
        } else if (session('event') == 'authLevel2') {
            if (session('status') == 'passwordIncorrect') {
                flash('密碼認證錯誤!!')->error();
                session()->forget(['event', 'status']);
                return redirect('/member_rigister');
            } else if (session('status') == 'failed') {
                flash('啟用失敗，請重新申請!!')->error();
                session()->forget(['event', 'status']);
                return redirect('/member_rigister');
            }
        }
        return view('authlevel.member_rigister');
    }
    public function authLevel2Store(EnableMemberRequest $request)
    {

        $isPass = false;
        $user = User::find(Auth::id());
        $isPass = Hash::check($request->password, $user->password);
        // dd($isPass);
        if ($isPass) {
            if (count(UserAdvance::where('user_id', Auth::id())->get()) == 0) {
                $user->identify = $request->identify;
                $user->username = $request->username;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->birthday = $request->birthday;
                $user->gender = $request->gender;
                $user->tel = $request->tel;
                $user->mobile = $request->mobile;
                $user->address = $request->address;
                $isUserUpdate = $user->save();
                $userAdvance = UserAdvance::create([
                    'user_id' => Auth::id(),
                    'country_id' => $request->userCountryId,
                    'city_id' => $request->userCityId,
                    'town_id' => $request->userTownId,
                    'road_id' => $request->userRoadId,
                    'phone_code_id' => $request->userPCountryId,
                    'local_phone_code_id' => $request->userPLocalId,
                    'auth_level_id' => AuthLevel::where('title', '會員功能啟用')->first()->id,
                ]);
            } else {
                // flash('您在過去已申請!!')->overlay();
                flash('您在過去已申請!!')->success(); //綠色框
                session(['event' => 'authLevel2', 'status' => 'noNeed']);
                return redirect('/dashboard');
            }
        } else {
            session(['event' => 'authLevel2', 'status' => 'passwordIncorrect']);
            return redirect('/member_rigister');
        }
        // $user = User::find(Auth::id());
        if ($userAdvance->wasRecentlyCreated && $isUserUpdate) {
            session()->forget(['event', 'status']);
            // flash('功能成功開通!!')->overlay(); //對話框
            flash('功能成功開通!!')->success(); //綠色框
            return redirect('/dashboard');
        } else {
            session(['event' => 'authLevel2', 'status' => 'failed']);
            return redirect('/member_rigister');
        }
    }
}