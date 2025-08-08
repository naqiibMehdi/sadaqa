<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    $users = $query->orderBy('subscribe_date', 'desc')->paginate(15)->withPath(UrlHelper::assetUrl('admin/users'));

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

    return redirect(UrlHelper::assetUrl('admin/users'))
      ->with('success', 'Utilisateur créé avec succès.');
  }

  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  public function update(Request $request, User $user)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'password' => 'nullable|string|min:8|confirmed',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
      'remove_image' => 'boolean'

    ]);

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      // Supprimer l'ancienne image si elle existe et n'est pas une URL externe
      if ($user->img_profile && !Str::startsWith($user->img_profile, 'http')) {
        Storage::disk('public')->delete($user->img_profile);
      }

      // Stocker la nouvelle image
      $imagePath = $request->file('image')->store('profile', 'public');
      $user->img_profile = $imagePath;
    } elseif ($request->has('remove_image') && $request->remove_image) {
      // Supprimer l'image actuelle
      if ($user->img_profile && !Str::startsWith($user->img_profile, 'http')) {
        Storage::disk('public')->delete($user->img_profile);
      }
      $user->img_profile = null;
    }


    $user->name = $validated['name'];
    $user->email = $validated['email'];


    if ($request->filled('password')) {
      $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect(UrlHelper::assetUrl('admin/users'))
      ->with('success', 'Utilisateur mis à jour avec succès.');
  }

  public function destroy(User $user)
  {
    $user->delete();

    return redirect(UrlHelper::assetUrl('admin/users'))
      ->with('success', 'Utilisateur supprimé avec succès.');
  }

  public function toggleStatus(User $user)
  {
    $user->update(['is_active' => !$user->is_active]);

    $status = $user->is_active ? 'activé' : 'désactivé';

    return back()->with('success', "Utilisateur {$status} avec succès.");
  }
}
