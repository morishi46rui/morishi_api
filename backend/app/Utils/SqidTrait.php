<?php

declare(strict_types=1);

namespace App\Utils;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait SqidTrait
{
    /**
     * idからsqidを取得
     */
    public function sqid(): string
    {
        return $this->toSqid('id', self::getClassNameForSqid());
    }

    /**
     * 指定したカラムの値からsqidを取得
     * @param string $columnName 対象にするカラム名
     * @param string $className sqidに使用するクラス名
     */
    public function toSqid(string $columnName, string $className): string
    {
        $value = $this->{$columnName};

        if ($value === null) {
            return '';
        }

        if (! is_int($value)) {
            $message = "Property '{$columnName}' must be integer";
            throw (new ErrorException($message, 500));
        }

        $sqidInstance = app(\App\Utils\Sqid::class);

        return $sqidInstance->encode($value, self::generateNumberFromClassName($className));
    }

    /**
     * sqidをもとにレコードを取得し、存在しない場合はnull
     *
     * @param string $sqid SQID
     * @return self|null レコード
     */
    public static function findBySqid(string $sqid): ?self
    {
        $sqidInstance = app(\App\Utils\Sqid::class);
        $decoded = $sqidInstance->decode($sqid);
        if ($decoded === null) {
            return null;
        }

        return static::find($decoded);
    }

    /**
     * sqidをもとにレコードを取得し、存在しない場合は例外
     *
     * @param string $sqid SQID
     * @return self レコード
     * @throws ModelNotFoundException
     */
    public static function findBySqidOrFail(string $sqid): self
    {
        $sqidInstance = app(\App\Utils\Sqid::class);
        $decoded = $sqidInstance->decode($sqid);
        if ($decoded === null) {
            throw (new ModelNotFoundException())->setModel(static::class);
        }

        // NOTE: デフォルトのfindOrFailだとエラーの場合メッセージに素のidが表示されるため、手動で例外を投げる
        $record = static::find($sqidInstance->decode($sqid));
        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(static::class);
        }

        return $record;
    }

    /**
     * 数字のIDを自分のクラスのSQIDとして変換
     */
    public static function encodeToSqid(?int $intId): string
    {
        if ($intId === null) {
            return '';
        }
        $sqid = app(\App\Utils\Sqid::class);
        $className = self::getClassNameForSqid();
        $ramdomNumber = self::generateNumberFromClassName($className);

        return $sqid->encode($intId, $ramdomNumber);
    }

    /**
     * SQIDを数字のIDに変換
     */
    public static function decodeSqid(?string $sqid): ?int
    {
        if ($sqid === null) {
            return null;
        }
        $sqidInstance = app(\App\Utils\Sqid::class);

        return $sqidInstance->decode($sqid);
    }

    /**
     * クラス名からランダムな数字を生成
     * NOTE: 変更する場合、既存レコードのSQIDが変わるため注意
     *
     * @param string $className クラス名
     * @return int クラス名から生成されたランダムな数字
     */
    private static function generateNumberFromClassName(string $className): int
    {
        return crc32($className);
    }

    /**
     * Sqidの生成に用いるクラス名を取得（クラスによって異なるクラス名を使用したい場合があるため）
     * NOTE: 変更する場合、既存レコードのSQIDが変わるため注意
     */
    private static function getClassNameForSqid(): string
    {
        return static::$sqidClassName ?? get_called_class();
    }
}
