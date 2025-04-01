<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\FirstUpperCase;
use App\Rules\NoNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\Rules\Phone;

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
            'first_name' => ['required', 'string', 'max:255', 'min:2', new NoNumbers(), new FirstUpperCase()],
            'last_name' => ['required', 'string', 'max:255', 'min:2', new NoNumbers(), new FirstUpperCase()],
            'patronymic' => ['nullable', 'string', 'max:255', 'min:2', new NoNumbers(), new FirstUpperCase()],
            'phone' => ['nullable', 'string', 'max:255', (new Phone)->international()->country('RU')],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:dns',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
