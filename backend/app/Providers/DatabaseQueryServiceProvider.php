<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class DatabaseQueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (config('logging.sql.enable') !== true) {
            return;
        }

        DB::listen(static function (QueryExecuted $event) {
            $sql = $event->connection
                ->getQueryGrammar()
                ->substituteBindingsIntoRawSql(
                    sql: $event->sql,
                    bindings: $event->connection->prepareBindings($event->bindings),
                );

            // SQLの整形
            $formattedSql = self::formatSql($sql);
            $message = self::generateMessage($event->time, $formattedSql);

            Log::debug($message);
        });

        // トランザクションの開始・コミット・ロールバック時にログを出力
        Event::listen(static fn (TransactionBeginning $event) => Log::debug("\033[1;32mBEGIN\033[0m"));
        Event::listen(static fn (TransactionCommitted $event) => Log::debug("\033[1;32mCOMMIT\033[0m"));
        Event::listen(static fn (TransactionRolledBack $event) => Log::debug("\033[1;32mROLLBACK\033[0m"));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private static function formatSql(string $sql): string
    {
        // キーワードを大文字に変換
        $keywords = [
            'select ',
            ' from ',
            ' where ',
            ' and ',
            ' or ',
            ' order by ',
            ' group by ',
            ' having ',
            ' join ',
            ' left join ',
            ' inner join ',
            ' limit ',
            ' offset ',
            'update ',
            ' set ',
            'delete ',
            'insert into',
        ];
        $sql = Str::of($sql);

        foreach ($keywords as $keyword) {
            $sql = $sql->replace(
                $keyword,
                mb_strtoupper($keyword),
                false
            );
        }

        return $sql->trim()->__toString();
    }

    private static function generateMessage(float $time, string $sql): string
    {
        // 実行時間が遅いクエリかどうか
        $isSlowQuery = $time > config('logging.sql.slow_query_time');

        $style = $isSlowQuery
            ? sprintf("\033[1;38;5;%dm", rand(150, 200)) // 太字・明るめの色
            : sprintf("\033[38;5;%dm", rand(0, 100));

        $format = $isSlowQuery
            ? "%sSQL (%.2fms) %s;\033[0m" // SQL全体を色付け
            : "%sSQL (%.2fms)\033[0m %s;";

        return sprintf(
            $format,
            $style,
            $time,
            $sql,
        );
    }
}
