<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'nip' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            $user = $request->user();

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->foto && $user->foto !== 'foto_pengguna/default.png' && Storage::exists('public/' . $user->foto)) {
                    Storage::delete('public/' . $user->foto);
                }

                // Simpan foto baru
                $fotoPath = $request->file('foto')->store('foto_pengguna', 'public');
                $user->foto = $fotoPath;
            }

            $user->nama_pengguna = $request->nama_pengguna;
            $user->nip = $request->nip;

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Terjadi kesalahan saat memperbarui profil');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
