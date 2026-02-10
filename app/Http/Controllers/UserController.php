<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $users = User::with('unit')->paginate(10);
        return view('user.index', compact('users'));
    }
    
    public function create()
    {
        $unit = Unit::all();
        $roles = Role::all();
        return view('user.create', compact('unit', 'roles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'unit_id' => 'nullable|exists:unit,id',
            'role' => 'required|exists:roles,name',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'unit_id' => $request->unit_id,
        ]);
        
        $user->assignRole($request->role);
        
        return redirect()->route('user.index')
            ->with('success', 'User berhasil dibuat.');
    }
    
    public function show($id)
    {
        $user = User::with('unit')->findOrFail($id);
        return view('user.show', compact('user'));
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $unit = Unit::all();
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();
        
        return view('user.edit', compact('user', 'unit', 'roles', 'userRole'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'unit_id' => 'nullable|exists:unit,id',
            'role' => 'required|exists:roles,name',
        ]);
        
        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->unit_id = $request->unit_id;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Update role
        $user->syncRoles([$request->role]);
        
        return redirect()->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting self
        if ($user->id == Auth::id()) {
            return redirect()->route('user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        $user->delete();
        
        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}