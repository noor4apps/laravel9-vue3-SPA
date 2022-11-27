<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return $users;
    }

    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|unique:users,email',
        ]);

        $request->merge([
            'password' => bcrypt($request['password'])
        ]);

        return User::create($request->all());
    }
}
