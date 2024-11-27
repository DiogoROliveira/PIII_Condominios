<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $existingUser = User::all()->first(function ($user) use ($value) {
                        try {
                            return Crypt::decrypt($user->email) === $value;
                        } catch (\Exception $e) {
                            return false;
                        }
                    });

                    if ($existingUser && $existingUser->id !== $this->user()->id) {
                        $fail(__('O :attribute já está em uso.', ['attribute' => $attribute]));
                    }
                },
            ],
        ];
    }
}
