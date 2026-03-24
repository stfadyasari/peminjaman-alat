<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role'=>'required'
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        ActivityLogger::log('user.create', 'Menambahkan user #'.$user->id.' ('.$user->name.', '.$user->role.')');
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'role'=>'required'
        ]);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        ActivityLogger::log('user.update', 'Mengubah user #'.$user->id.' ('.$user->name.', '.$user->role.')');
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $userId = $user->id;
        $userName = $user->name;
        $user->delete();
        ActivityLogger::log('user.delete', 'Menghapus user #'.$userId.' ('.$userName.')');
        return back();
    }
}
