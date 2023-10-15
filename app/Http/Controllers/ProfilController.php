<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ProfilController extends Controller
{
    public function profil()
{
    $user = auth()->user(); // Pobierz zalogowanego użytkownika
    return view('profil', compact('user'));
}

    

    public function uploadAvatar(Request $request)
{
    $user = auth()->user();
    
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();
    }

    return redirect()->route('profil')->with('success', 'Zdjęcie profilowe zostało zaktualizowane.');
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Sprawdź i zweryfikuj dane wejściowe
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Zaktualizuj dane użytkownika
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->save();

    return redirect()->route('profil')->with('success', 'Dane użytkownika zostały zaktualizowane.');
}

}
