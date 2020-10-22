<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $messages = $messages ??
        $messages = [
            'required' => 'O campo ":attribute" é obrigatório',
            'email' => 'O campo ":attribute" deve ser um e-mail válido'
        ];

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        return $this->extractInputFromRules($request, $rules);
    }

    protected function getRequestUser(): User
    {
        return User::hydrate([
            json_decode(USER_REQUEST, true)
        ])->first();
    }
}
