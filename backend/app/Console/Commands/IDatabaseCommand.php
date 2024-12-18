<?php

declare(strict_types=1);

namespace App\Console\Commands;

interface IDatabaseCommand
{
    public function existTable(): bool;

    public function dropAllTables(): void;
}
