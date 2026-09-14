<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    public function index()
    {
        $keys = ApiKey::orderByDesc('created_at')->get();
        return view('api-keys.index', compact('keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'       => 'required|string|max:100',
            'expires_at'  => 'nullable|date|after:today',
            'scopes'      => 'nullable|array',
            'is_active'   => 'boolean',
        ]);

        [$apiKey, $rawKey] = ApiKey::generate(
            label: $request->label,
            options: [
                'expires_at' => $request->expires_at
                    ? \Carbon\Carbon::parse($request->expires_at)
                    : now()->addDays(90),
                'scopes'     => $request->scopes ?? ['*'],
                'is_active'  => $request->boolean('is_active', true),
                'created_by' => Auth::id(),
            ]
        );

        return redirect()->route('api-keys.index')
            ->with('success', 'API Key berhasil dibuat')
            ->with('new_key', $rawKey)
            ->with('new_key_id', $apiKey->id);
    }

    public function update(Request $request, ApiKey $apiKey)
    {
        $request->validate([
            'label'       => 'required|string|max:100',
            'is_active'   => 'boolean',
        ]);

        $apiKey->update([
            'label'     => $request->label,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('api-keys.index')
            ->with('success', "Key \"{$apiKey->label}\" berhasil diupdate");
    }

    public function destroy(ApiKey $apiKey)
    {
        $label = $apiKey->label;
        $apiKey->delete();

        return redirect()->route('api-keys.index')
            ->with('success', "Key \"{$label}\" berhasil dihapus");
    }

    public function rotate(ApiKey $apiKey)
    {
        $label = $apiKey->label;

        $newRaw = strtoupper(\Illuminate\Support\Str::random(4)) . '-' .
                  strtoupper(\Illuminate\Support\Str::random(4)) . '-' .
                  strtoupper(\Illuminate\Support\Str::random(4)) . '-' .
                  strtoupper(\Illuminate\Support\Str::random(4));

        $apiKey->update([
            'key_hash'   => hash('sha256', $newRaw),
            'key_prefix' => substr($newRaw, 0, 8),
            'expires_at' => now()->addDays(90),
            'is_active'  => true,
        ]);

        return redirect()->route('api-keys.index')
            ->with('success', "Key \"{$label}\" berhasil di-rotate")
            ->with('new_key', $newRaw)
            ->with('new_key_id', $apiKey->id);
    }

    public function toggle(ApiKey $apiKey)
    {
        $apiKey->update(['is_active' => !$apiKey->is_active]);
        $status = $apiKey->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('api-keys.index')
            ->with('success', "Key \"{$apiKey->label}\" {$status}");
    }
}
