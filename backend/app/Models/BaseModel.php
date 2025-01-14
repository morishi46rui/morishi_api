<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\SqidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 共通の設定やメソッドを追加するためのベースモデル
 */
abstract class BaseModel extends Model
{
    use HasFactory;
    use SqidTrait;
}
