<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'registerRequest',
    title: 'アカウント新規作成リクエスト',
    type: 'object',
    required: ['name', 'email', 'password', 'passwordConfirmation'],
    properties: [
        new OA\Property(
            property: 'name',
            ref: '#/components/schemas/user/properties/name',
        ),
        new OA\Property(
            property: 'email',
            ref: '#/components/schemas/user/properties/email',
        ),
        new OA\Property(
            property: 'password',
            ref: '#/components/schemas/user/properties/password',
        ),
        new OA\Property(
            property: 'passwordConfirmation',
            ref: '#/components/schemas/user/properties/password',
        ),
    ]
)]
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:30',
                'regex:/^[^\s]+$/',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[^\s]+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ],
            'passwordConfirmation' => ['required', 'string', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'パスワードには、大文字、小文字、数字、記号をそれぞれ1つ以上含めてください。',
        ];
    }
}
