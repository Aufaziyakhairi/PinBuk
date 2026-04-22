<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $borrowing = $this->route('borrowing');
        
        // Only admin can approve/reject requests
        if (in_array($this->input('status'), ['approved', 'rejected'])) {
            return $this->user()->isAdmin();
        }
        
        // Users can return their own books
        if ($this->input('status') === 'returned') {
            return $this->user()->isAdmin() || $this->user()->id === $borrowing->user_id;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:approved,rejected,returned',
            'due_date' => 'required_if:status,approved|nullable|date|after_or_equal:today',
            'returned_at' => 'required_if:status,returned|nullable|date',
        ];
    }
}

