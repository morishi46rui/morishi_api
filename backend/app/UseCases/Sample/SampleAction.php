<?php

declare(strict_types=1);

namespace App\UseCases\Sample;

class SampleAction
{
    /**
     * @return array{sample: int}
     */
    public function __invoke(): array
    {
        return ['sample' => 1];
    }
}
