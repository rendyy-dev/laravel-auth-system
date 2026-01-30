<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9_-]+$/',
                'unique:users,username,' . $this->user()->id,
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $this->user()->id,
            ],

            'telepon' => [
                'nullable',
                'string',
                'max:20',
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            // name
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',

            // username
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' =>
                'Username hanya boleh huruf kecil, angka, tanpa spasi.',
            'username.max' => 'Username maksimal 50 karakter.',

            // email
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.max' => 'Email maksimal 255 karakter.',

            // telepon
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',

            // alamat
            'alamat.max' => 'Alamat maksimal 1000 karakter.',

            // avatar
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' =>
                'Avatar harus berformat JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran avatar maksimal 2MB.',
        ];
    }
}
