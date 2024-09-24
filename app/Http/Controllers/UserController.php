<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Method that retrieves all users of db.
    function getUsers(Request $request)
    {

        if (!$request->user()->hasRole(['admin'])) {
            return response()->json(
                ["message" => "You are not allowed to see this information"],
                401
            );
        }
        $users = User::all();


        return response()->json(
            [$users],
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getUser(Request $request, int $id)
    {

        try {
            $user = User::find($id);

            if ($request->user()->hasRole(['user', 'writer'])) {
                if ($user->id != $request->user()->id) {
                    return response()->json(
                        ["message" => "You are not allowed to see this user's information"],
                        401
                    );
                }
            }

            if ($user == null) {
                return response()->json(
                    ["error" => "The user you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(
                [$user],
                200
            );
        } catch (Exception $e) {
        }
    }


    //Method that edits an existing user of db.
    function editUser(Request $request, int $id)
    {
        $validated = $request->validate([
            "password" => ["max:50", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
        ]);


        $user = User::find($id);

        if ($request->user()->hasRole(['user', 'writer'])) {
            if ($user->id != $request->user()->id) {
                return response()->json(
                    ["message" => "You are not allowed to edit this user"],
                    401
                );
            }
        }

        if ($request->name) {
            $user->name = $request['name'];
        }

        if ($request->surname) {
            $user->surname = $request['surname'];
        }

        if ($request->username) {
            $user->username = $request['username'];
        }

        if ($request->email) {
            $user->email = $request['email'];
        }

        if ($request->password != "") {
            $user->password = Hash::make($request['password']);
        }

        $user->save();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully edited"
            ],
            200
        );


        return response()->json($request->user(), 200);
    }


    //Method that creates a new user on db.
    function register(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required"],
            "surname" => ["required"],
            "username" => ["required"],
            "password" => ["required", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
            "email" => ["required"],
        ]);


        $user = new User();
        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['name']);
        $user->assignRole("user");

        $user->save();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully created"
            ],
            200
        );
    }


    //Login
    function login(Request $request)
    {
        $user = User::where('username',  $request->username)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['Username or password incorrect'],
            ]);
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    //Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]
        );
    }
}
