<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email:rfc', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8']
        ])->validate();

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['email'] = strtolower($data['email']);

        $user = User::create($data);

        return redirect()->route('user.edit', $user->id)->with('success', trans('messages.itemCreated'));
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email:rfc', Rule::unique('users')->ignoreModel($user)],
            'password' => ['nullable', 'confirmed', 'min:8']
        ])->validate();

        $data = $request->all();
        $data['email']    = strtolower($data['email']);
        $data['password'] = (empty($request->password)) ? $user->password : bcrypt($data['password']);

        $user->update($data);

        return redirect()->route('user.edit', $user->id)->with('success', trans('messages.itemUpdated'));
    }
}
