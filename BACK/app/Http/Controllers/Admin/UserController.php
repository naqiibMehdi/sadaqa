<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $query = User::query();

    // Recherche
    if ($request->has('search') && $request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->search . '%')
          ->orWhere('email', 'like', '%' . $request->search . '%');
      });
    }

    // Filtre par statut
    if ($request->has('status') && $request->status) {
      $query->where('is_active', $request->status === 'active');
    }

    $users = $query->orderBy('subscribe_date', 'desc')->paginate(15);

    return view('admin.users.index', compact('users'));
  }

  public function show(User $user)
  {
    return view('admin.users.show', compact('user'));
  }

  public function create()
  {
    return view('admin.users.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'first_name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
      'name' => $request->name,
      "first_name" => $request->first_name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.users.index')
      ->with('success', 'Utilisateur créé avec succès.');
  }

  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'password' => 'nullable|string|min:8|confirmed',
    ]);

    $data = [
      'name' => $request->name,
      'email' => $request->email,
    ];

    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')
      ->with('success', 'Utilisateur mis à jour avec succès.');
  }

  public function destroy(User $user)
  {
    $user->delete();

    return redirect()->route('admin.users.index')
      ->with('success', 'Utilisateur supprimé avec succès.');
  }

  public function toggleStatus(User $user)
  {
    $user->update(['is_active' => !$user->is_active]);

    $status = $user->is_active ? 'activé' : 'désactivé';

    return back()->with('success', "Utilisateur {$status} avec succès.");
  }
}
