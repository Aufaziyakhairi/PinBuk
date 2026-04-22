<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admin can create fines
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'borrowing_id' => 'required|exists:borrowings,id',
            'description' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'borrowing_id.required' => 'Peminjaman harus dipilih',
            'borrowing_id.exists' => 'Peminjaman tidak ditemukan',
            'description.required' => 'Deskripsi denda harus diisi',
            'description.max' => 'Deskripsi denda maksimal 1000 karakter',
        ];
    }
}
