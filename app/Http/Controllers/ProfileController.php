<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user()->load('profile');
        return view('profile.settings', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20|unique:user_profiles,nip,' . ($user->profile?->id ?? 'NULL'),
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat_instansi' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update atau create profile
        $profile = $user->profile ?? new UserProfile();
        $profile->fill($request->only([
            'nama_lengkap', 'instansi', 'nip', 'email', 'no_hp', 'alamat_instansi'
        ]));
        $profile->user_id = $user->id;
        $profile->save();

        // Update completeness
        $profile->calculateCompleteness();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        // Hapus avatar lama
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $profile->avatar = $path;
        $profile->save();

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    public function updateSignature(Request $request): RedirectResponse
    {
        $request->validate([
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        // Hapus signature lama
        if ($profile->signature) {
            Storage::disk('public')->delete($profile->signature);
        }

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $profile->signature = $path;
            $profile->signature_mime = $request->file('signature')->getMimeType();
            $profile->signature_size = $request->file('signature')->getSize();
        } else {
            // Canvas signature (base64)
            $signatureData = $request->input('signature_canvas');
            if ($signatureData && strpos($signatureData, 'data:image') === 0) {
                $data = explode(',', $signatureData)[1];
                $data = base64_decode($data);
                $filename = 'signature_' . $user->id . '_' . time() . '.png';
                $path = 'signatures/' . $filename;
                Storage::disk('public')->put($path, $data);
                $profile->signature = $path;
                $profile->signature_mime = 'image/png';
                $profile->signature_size = strlen($data);
            }
        }

        $profile->save();
        $profile->calculateCompleteness();

        return back()->with('success', 'Tanda tangan berhasil disimpan!');
    }

    public function getSessions(): View
    {
        $user = Auth::user();
        // Implementasi session tracking bisa ditambahkan di sini
        return view('profile.settings', compact('user'));
    }
}