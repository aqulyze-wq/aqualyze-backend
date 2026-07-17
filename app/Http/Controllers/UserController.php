<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ActivityHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        ActivityHelper::log(

            'User',

            'Menambahkan user '.$request->name

        );

        return redirect()
            ->route('users.index')
            ->with('success','User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, User $user)
    {
        $request->validate([

            'name'=>'required',

            'email'=>'required|email|unique:users,email,'.$user->id,

            'role'=>'required'

        ]);

        $user->update([

            'name'=>$request->name,

            'email'=>$request->email,

            'role'=>$request->role

        ]);

        ActivityHelper::log(

            'User',

            'Mengubah user '.$user->name

        );

        return redirect()

            ->route('users.index')

            ->with('success','User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        ActivityHelper::log(

            'User',

            'Menghapus user '.$user->name

        );

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success','User berhasil dihapus.');
    }
}
