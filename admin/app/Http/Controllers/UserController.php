<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,manager,user',
        ]);
        $user = new User();
        $user->fill($validated);
        $user->password = bcrypt(bin2hex(random_bytes(8)));
        $user->approved = true;
        $user->email_verified_at = now();
        $user->save();
        \Illuminate\Support\Facades\Password::sendResetLink($user->only('email'));
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,user',
        ]);
        $user->update($validated);
        if ($user->id == 1) {
            $user->role = 'admin';
        }
        $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id == 1) {
            return redirect()->route('users.index');
        }
        $user->email_verified_at = null;
        $user->email = "dead" . $user->id . "@localhost";
        $user->name = "dead" . $user->id;
        $user->password = bcrypt(bin2hex(random_bytes(8)));
        $user->save();
        $user->delete();
        return redirect()->route('users.index');
    }

    /**
     * Change approval status of the specified resource.
     */
    public function approval(User $user)
    {
        if ($user->id == 1) {
            return redirect()->route('users.index');
        }
        $user->approved = !$user->approved;
        $user->save();
        return redirect()->route('users.index');
    }
}
