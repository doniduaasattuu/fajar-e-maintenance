<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Services\UserService;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registration()
    {
        return response()->view('user.registration', [
            'title' => 'Registration',
            'userService' => $this->userService,
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'nik' => ['required', 'size:8', !Rule::in($this->userService->niks())],
            'password' => ['required', 'min:6'],
            'fullname' => ['required'],
            'department' => ['required', Rule::in($this->userService->departments())],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'registration_code' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            // $this->userService->register($validator->validated());

            try {
            } catch (QueryException $error) {
                return redirect()->back()->withErrors($error)->withInput();
            }
        }
    }

    public function login()
    {
        return response()->view('user.login', [
            'title' => 'Login'
        ]);
    }

    public function doLogin(Request $request)
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
