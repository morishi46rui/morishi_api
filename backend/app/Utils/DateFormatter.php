<?php

declare(strict_types=1);

namespace App\Utils;

use Carbon\Carbon;

class DateFormatter
{
    /**
     * 日付を指定されたフォーマットに変換します。
     *
     * @param string $date 日付文字列
     * @param string $format フォーマット文字列
     * @param string|null $timezone タイムゾーン(省略可能)
     * @return string フォーマットされた日付文字列
     */
    public static function format(string $date, string $format = 'Y-m-d H:i:s', ?string $timezone = null): string
    {
        $carbonDate = Carbon::parse($date);

        if ($timezone) {
            $carbonDate->setTimezone($timezone);
        }

        return $carbonDate->format($format);
    }

    /**
     * 日付を日本時間に変換してフォーマットします。
     *
     * @param string $date 日付文字列
     * @param string $format フォーマット文字列
     * @return string フォーマットされた日付文字列
     */
    public static function formatToJapanTime(string $date, string $format = 'Y-m-d H:i:s'): string
    {
        return self::format($date, $format, 'Asia/Tokyo');
    }
}
