<?php

declare(strict_types=1);

namespace App\Utils;

//  メールアドレスが複数件カンマ区切りで入力された場合、
//  各メールアドレスの前後のスペースを削除し、データベースに保存する処理
class EmailSaveFormatter
{
    public static function trimEmailArray(string $emails): string
    {
        $emailsArray = explode(',', $emails);
        $trimmedEmailsArray = array_map('trim', $emailsArray);

        return implode(',', $trimmedEmailsArray);
    }

    public static function trimEmailColumns(array $attributes, array $columns): array
    {
        foreach ($columns as $column) {
            if (isset($attributes[$column])) {
                $attributes[$column] = self::trimEmailArray($attributes[$column]);
            }
        }

        return $attributes;
    }
}
