<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EnableMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check(); //已通過身分驗證
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $birth12Y = Carbon::now()->subYears(12)->toString();
        return [
            'identify' => "required|max:20|alpha_num",
            'username' => "required|filled",
            'first_name' => "required|max:45|filled",
            'last_name' => "required|max:45|filled",
            'birthday' => "required|before:{$birth12Y}",
            'gender' => "required",
            'tel' => "max:14|regex:/^[0-9]+$/",
            'mobile' => "required|max:20|regex:/^[0-9]+$/",
            'city' => "required",
            'town' => "required",
            'road' => "required",
            'address' => "required|max:100|filled",
            'userCountryId' => "required|regex:/^[0-9]+$/",
            'userCityId' => "required|regex:/^[0-9]+$/",
            'userTownId' => "required|regex:/^[0-9]+$/",
            'userRoadId' => "required|regex:/^[0-9]+$/",
            'userPLocalId' => "required|regex:/^[0-9]+$/",
            'userPCountryId' => "required|regex:/^[0-9]+$/",
        ];

    }
}