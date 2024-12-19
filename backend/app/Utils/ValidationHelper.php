<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Validation\ValidationException;

class ValidationHelper
{
    /**
     * バリデーションエラーメッセージを投げる共通メソッド
     *
     * @param string $field フィールド名
     * @param string $message エラーメッセージ
     * @throws ValidationException
     */
    public static function throwValidationException(string $field, string $message): void
    {
        throw ValidationException::withMessages([
            $field => [$message],
        ]);
    }
}
