<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\APIRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\Auth\Rules\NotAdmin;

class CreateUserRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'username' => 'required|unique:users',
            'password' => 'required',
            'fullname' => 'required',
            'email' => 'required|unique:users',
            'role_id' => ['required', 'exists:roles,id', new NotAdmin()],
            'university_id' => 'exists:universities,id'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
