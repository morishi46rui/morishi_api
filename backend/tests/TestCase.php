<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Tests\Helpers\TestHelper;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestHelper;
    use ValidatesOpenApiSpec;
}
