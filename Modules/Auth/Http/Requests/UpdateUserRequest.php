<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\APIRequest;
use Modules\Auth\Rules\NotAdmin;

class UpdateUserRequest extends APIRequest
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
            'username' => '',
            'password' => '',
            'fullname' => '',
            'email' => '',
            'role_id' => ['exists:roles,id', new NotAdmin()],
            'university_id' => 'exists:universities,id',
            'permissions' => ''
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
