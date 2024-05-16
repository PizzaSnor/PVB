<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], $this->customValidationMessages());

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Get custom validation error messages.
     *
     * @return array
     */
    protected function customValidationMessages(): array
    {
        return [
            'current_password.required' => 'Het huidige wachtwoord is vereist.',
            'current_password.current_password' => 'Het huidige wachtwoord is onjuist.',
            'password.required' => 'Het nieuwe wachtwoord is vereist.',
            'password.confirmed' => 'Het nieuwe wachtwoord komt niet overeen met de bevestiging.',
        ];
    }
}
