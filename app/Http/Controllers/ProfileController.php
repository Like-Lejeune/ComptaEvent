<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Afficher la liste des profils
    public function index()
    {
        $profiles = Profile::all();
        return view('profile.index', compact('profiles'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('profile.create');
    }

    // Enregistrer un nouveau profil
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:profiles|max:255',
            'description' => 'nullable|string',
            'list_action' => 'nullable|json',
        ]);

        Profile::create($validatedData);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully');
    }

    // Afficher un profil spécifique
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profile.show', compact('profile'));
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profile.edit', compact('profile'));
    }

    // Mettre à jour un profil
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|unique:profiles,name,' . $id . '|max:255',
            'description' => 'nullable|string',
            'list_action' => 'nullable|json',
        ]);

        $profile->update($validatedData);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully');
    }

    // Supprimer un profil
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully');
    }
}
