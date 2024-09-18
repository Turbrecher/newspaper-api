<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Method that retrieves all users of db.
    function getUsers()
    {
        $users = User::all();


        return response()->json(
            [$users],
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getUser(int $id)
    {

        try {
            $user = User::find($id);

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


    //Method that creates a new user on db.
    function createUser(Request $request)
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
        $user->assignRole("general");

        $user->save();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully created"
            ],
            200
        );
    }

    //Method that edits an existing user of db.
    function editUser(Request $request, int $id)
    {
        $validated = $request->validate([
            "name" => ["required"],
            "surname" => ["required"],
            "username" => ["required"],
            "password" => ["max:50", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$"],
            "email" => ["required"],
        ]);


        $user = User::find($id);
        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->username = $request['username'];
        $user->email = $request['email'];

        if ($request->password != "") {
            $user->password = Hash::make($request['name']);
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
}
