<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $data = [
            'nik' => $request->input('nik'),
            'password' => $request->input('password'),
        ];

        $rules = [
            'nik' => ['required', 'size:8'],
            'password' => ['required'],
        ];

        $validator = Validator::make($data, $rules);

        try {
            $valid = $validator->validate()[0];

            if ($this->userService->login($valid->nik, $valid->password)) {
                return 'Hello world';
            }
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors();
            return $message;
        }
    }
}
