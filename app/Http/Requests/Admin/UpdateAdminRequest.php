<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Route ini sudah dibungkus middleware EnsureSuperAdmin.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $admin = $this->route('adminUser');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('admins', 'email')->ignore($admin?->id),
            ],
            // Password is optional on update: leave blank to keep the current one.
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:'.Admin::ROLE_ADMIN.','.Admin::ROLE_SUPER_ADMIN],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh admin lain.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'role.required' => 'Peran admin wajib dipilih.',
            'role.in' => 'Peran admin tidak valid.',
        ];
    }
}
