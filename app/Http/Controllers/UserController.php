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
                "error" => "NIK and password is required! ⚠️",
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

    // REGISTRATION
    public function registration()
    {
        return response()->view("user.registration", [
            "title" => "Registration"
        ]);
    }

    public function register(Request $request)
    {
        $nik = $request->input("nik");
        $password = $request->input("password");
        $fullname = $request->input("fullname");
        $department = $request->input("department");
        $phone_number = $request->input("phone_number");

        if (
            empty($nik) ||
            empty($password) ||
            empty($fullname) ||
            empty($department) ||
            empty($phone_number)
        ) {
            return response()->view("user.registration", [
                "title" => "Registration",
                "error" => "All data is required! ⚠️"
            ]);
        }

        $user = User::query()->find($nik);

        if ($user == null) {

            $user = new User();
            $user->nik = $nik;
            $user->password = $password;
            $user->fullname = $fullname;
            $user->department = $department;
            $user->phone_number = $phone_number;

            $registration_success = $user->save();

            if ($registration_success) {
                return response()->view("user.login", [
                    "title" => "Login",
                    "registration_success" => true
                ]);
            } else {
                return response()->view("user.registration", [
                    "title" => "Registration",
                    "error" => "Registration error! ⚠️"
                ]);
            }
        } else {
            return response()->view("user.registration", [
                "title" => "Registration",
                "error" => "NIK is used! ⚠️"
            ]);
        }
    }

    // CHANGE NAME
    public function changeName(Request $request)
    {
        return response()->view("user.change-name", [
            "title" => "Change name",
        ]);
    }

    public function doChangeName(Request $request)
    {
        $nik = $request->input("nik");
        $password = $request->input("password");
        $name = $request->input("name");

        if (empty($nik) || empty($password) || empty($name)) {
            return response()->view("user.change-name", [
                "title" => "Change name",
                "error" => "All data is required! ⚠️"
            ]);
        }

        $user = User::query()->find($nik);

        if (!is_null($user)) {

            if ($user->password == $password) {

                $user->fullname = $name;
                $user->save();

                session(["nik" => $user->nik]);
                session(["user" => $user->fullname]);

                return redirect("/")->with("message", "Your name has been successfully changed.");
            } else {
                return response()->view("user.change-name", [
                    "title" => "Change name",
                    "error" => "NIK or password is wrong! ⚠️"
                ]);
            }
        } else {
            return response()->view("user.change-name", [
                "title" => "Change name",
                "error" => "NIK or password is wrong! ⚠️"
            ]);
        }
    }
}
