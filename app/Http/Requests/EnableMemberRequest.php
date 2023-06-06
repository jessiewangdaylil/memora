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
        $birth12 = Carbon::now()->subYears(12)->toString();

        return [
            'username' => "required|filled",
            'first_name' => "required|max:45|filled",
            'last_name' => "required|max:45|filled",
            'gender' => "required|max:20|alpha",
            'identify' => "required|max:20|alpha_num",
            'birthday' => "required|before:{$birth12}",
            'tel' => "required|max:14|numeric",
            'mobile' => "required|max:20|numeric",
            'post_id' => "required|max:5",
            'address' => "required|max:100|filled"];

    }
}