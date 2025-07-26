<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;



class UserController extends Controller
{  

    public function index(Request $request)
    {
        $search = $request->get('search');
        $roleFilter = $request->get('role');

        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%");
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('name', $roleFilter);
                });
            })
            ->paginate(5);

        $roles = Role::pluck('name', 'name'); // Ambil dari database

        return view('user.index', compact('users', 'search', 'roleFilter', 'roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name'); // Ambil role dari database
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name', // Validasi berdasarkan role di database
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role); // Assign role dengan Spatie

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name'); // Ambil role dari database
        return view('user.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'nullable|min:6|confirmed', 
            'role' => 'required|exists:roles,name', // Validasi peran dari database
        ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->syncRoles([$request->role]); // Update role dengan Spatie

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
