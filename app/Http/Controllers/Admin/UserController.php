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
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $request->merge([
            'password' => bcrypt($request['password'])
        ]);

        return User::create($request->all());
    }

    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
        ]);

        $request->merge([
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        $user->update($request->all());

        return $user;
    }
}
