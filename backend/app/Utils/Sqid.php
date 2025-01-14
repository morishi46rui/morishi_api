<?php

declare(strict_types=1);

namespace App\Utils;

use Sqids\Sqids;

/**
 * カスタムSqidクラス
 */
class Sqid
{
    protected $sqids;

    public function __construct()
    {
        $this->sqids = new Sqids(
            // 大文字、小文字、数字を重複なしでランダムに並び替えた文字列
            // NOTE: 変更する場合、既存レコードのSQIDが変わるため注意
            alphabet: env('SQID_ALPHABET', 'Uox6jn1TAFp2CIbk58aDWyLfJRged0XiqhS4O9PMVsNGB7t3ZlrvYwQumcKEzH'),
            minLength: 12
        );
    }

    /**
     * レコードIDとランダムな数字を組み合わせてSQIDを生成
     * NOTE: 変更する場合、既存レコードのSQIDが変わるため注意
     *
     * @param int $recordId レコードID
     * @param int $ramdomNumber ランダムな数字
     * @return string SQID
     */
    public function encode($recordId, $ramdomNumber): string
    {
        return $this->sqids->encode([$recordId, $ramdomNumber]);
    }

    /**
     * sqidからランダムな数字を除く、元のIDを取得。不正なSQIDの場合はnullを返す
     * NOTE: 変更する場合、既存レコードのSQIDが変わるため注意
     *
     * @param string $sqid SQID
     * @return int|null 元のID
     */
    public function decode(string $sqid): ?int
    {
        $decoded = $this->sqids->decode($sqid);

        // 再エンコードして元のSQIDと一致するか確認
        $reEncorded = $this->sqids->encode($decoded);
        if ($reEncorded !== $sqid) {
            return null;
        }

        return $this->sqids->decode($sqid)[0];
    }
}
