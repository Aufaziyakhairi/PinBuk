<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Show list of all users (admin only)
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $query = User::query();

        // Search by name or email
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if (request('role')) {
            $query->where('role', request('role'));
        }

        $users = $query->latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show form to create a new user (admin only)
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('users.create');
    }

    /**
     * Store a newly created user (admin only)
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        if (!auth()->user()->isAdmin() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show form to edit user
     */
    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update user information
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // Admin can also update role
        if (auth()->user()->isAdmin()) {
            $validated['role'] = $request->validate(['role' => ['required', 'in:admin,user']])['role'];
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus user sendiri');
        }

        // Prevent deleting other admin accounts
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus akun admin. Ubah role menjadi user terlebih dahulu.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
