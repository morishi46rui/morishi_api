<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'registerResponse',
    type: 'object',
    description: 'アカウント新規作成成功',
    required: ['id', 'name', 'email'],
    properties: [
        new OA\Property(
            property: 'id',
            ref: '#/components/schemas/user/properties/id',
        ),
        new OA\Property(
            property: 'name',
            ref: '#/components/schemas/user/properties/name',
        ),
        new OA\Property(
            property: 'email',
            ref: '#/components/schemas/user/properties/email'
        ),
    ]
)]

class RegisterAction
{
    public function __invoke($request): array
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return [
            'id' => $user->sqid(),
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
