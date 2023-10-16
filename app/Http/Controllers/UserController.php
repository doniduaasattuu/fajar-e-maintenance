<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // LOGIN
    public function login()
    {
        return response()->view("user.login", [
            "title" => "Login"
        ]);
    }

    public function doLogin(Request $request)
    {
        $nik = $request->input("NIK");
        $password = $request->input("password");

        if (empty($nik) or empty($password)) {

            return response()->view("user.login", [
                "title" => "Login",
                "error" => "NIK and password is required! ⚠️ "
            ]);
        }

        $user = User::query()->find($nik);

        if ($user != null && $user->password == $password) {
            session(["nik" => $user->nik]);
            session(["user" => $user->fullname]);

            return redirect("/");
        } else {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "NIK or password is wrong! ⚠️ "
            ]);
        }
    }
}
