<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\SqidTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'user',
    title: 'ユーザー',
    type: 'object',
    description: 'ユーザー',
    properties: [
        new OA\Property(property: 'id', type: 'integer', format: 'int64', description: 'ID', example: 1),
        new OA\Property(property: 'name', type: 'string', description: '名前', example: 'rui'),
        new OA\Property(property: 'email', type: 'string', description: 'メールアドレス', example: 'rui@example.com'),
        new OA\Property(property: 'password', type: 'string', description: 'パスワード', example: 'P@ssw0rd'),
        new OA\Property(property: 'onetimePassword', type: 'string', description: 'ワンタイムパスワード', example: '123456'),
        new OA\Property(
            property: 'otpExpiration',
            type: 'string',
            format: 'date-time',
            description: 'ワンタイムパスワード有効期限',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(property: 'loginShippaiKaisuu', type: 'integer', description: 'ログイン失敗回数', example: 3),
        new OA\Property(
            property: 'lastLoginDatetime',
            type: 'string',
            format: 'date-time',
            description: '最終ログイン日時',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'accountLockedDatetime',
            type: 'string',
            format: 'date-time',
            description: 'アカウントロック日時',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'emailVerifiedAt',
            type: 'string',
            format: 'date-time',
            description: 'メール認証日時',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(property: 'remember_token', type: 'string', description: 'リメンバートークン', example: 'token'),
        new OA\Property(
            property: 'deletedAt',
            type: 'string',
            format: 'date-time',
            description: '削除日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'createdAt',
            type: 'string',
            format: 'date-time',
            description: '作成日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'updatedAt',
            type: 'string',
            format: 'date-time',
            description: '更新日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
    ]
)]

class User extends Authenticatable implements AuthenticatableContract, CanResetPassword
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use SqidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'onetime_password',
        'otp_expiration',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
    ];
}
