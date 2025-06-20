<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;

class MakeApiController extends ControllerMakeCommand
{
    protected $name = 'make:apicontroller';

    protected function getStub(): string
    {
        return base_path('stubs/api-controller.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Http\\Controllers';
    }

    protected function buildClass($name): string
    {
        $className = class_basename($name);
        $baseName = Str::replaceLast('Controller', '', $className);
        $tag = $baseName;
        $path = Str::kebab($baseName);
        $ref = lcfirst($baseName) . 'Response';

        $this->createActionClass($baseName, $ref);
        $this->createControllerTest($className, $path);
        $this->createActionTest($baseName);

        $replace = [
            'DummyClass' => $className,
            'DummyNamespace' => $this->getNamespace($name),
            'DummyTag' => $tag,
            'dummy_path' => $path,
            'DummyRef' => $ref,
        ];

        $stub = file_get_contents($this->getStub());

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    protected function createActionClass(string $baseName, string $schemaName): void
    {
        $filesystem = app(Filesystem::class);

        $dir = app_path("UseCases/{$baseName}");
        $path = "{$dir}/{$baseName}Action.php";

        if (! $filesystem->exists($path)) {
            $filesystem->ensureDirectoryExists($dir);

            $code = <<<PHP
                    <?php

                    declare(strict_types=1);

                    namespace App\UseCases\\{$baseName};

                    use OpenApi\Attributes as OA;

                    #[OA\Schema(
                        schema: '{$schemaName}',
                        type: 'object',
                        description: '{$baseName}のサンプルレスポンス',
                        required: ['sample'],
                        properties: [
                            new OA\Property(
                                property: 'sample',
                                description: 'サンプル',
                                type: 'integer',
                                example: 1
                            ),
                        ]
                    )]
                    final class {$baseName}Action
                    {
                        public function __invoke(): array
                        {
                            return ['sample' => 1];
                        }
                    }

                    PHP;

            $filesystem->put($path, $code);
            $this->components->info("Created Action: App\\UseCases\\{$baseName}\\{$baseName}Action");
        }
    }

    protected function createControllerTest(string $controllerClass, string $routeName): void
    {
        $filesystem = app(Filesystem::class);

        $testDir = base_path('tests/Feature/HTTP/Controllers/Api/V1');
        $testPath = "{$testDir}/{$controllerClass}Test.php";

        if (! $filesystem->exists($testPath)) {
            $filesystem->ensureDirectoryExists($testDir);

            $code = <<<PHP
                    <?php

                    declare(strict_types=1);

                    namespace Tests\Feature\HTTP\Controllers\Api\V1;

                    use Illuminate\Foundation\Testing\RefreshDatabase;
                    use PHPUnit\Framework\Attributes\Test;
                    use Spectator\Spectator;
                    use Tests\TestCase;

                    class {$controllerClass}Test extends TestCase
                    {
                        use RefreshDatabase;

                        #[Test]
                        public function レスポンス200が返ること(): void
                        {
                            Spectator::using('api-docs.json');

                            \$this->getJson('/api/v1/{$routeName}')
                                ->assertValidRequest()
                                ->assertValidResponse(200);
                        }
                    }

                    PHP;

            $filesystem->put($testPath, $code);
            $this->components->info("Created Test: tests/Feature/HTTP/Controllers/Api/V1/{$controllerClass}Test.php");
        }
    }

    protected function createActionTest(string $baseName): void
    {
        $filesystem = app(Filesystem::class);

        $dir = base_path("tests/Unit/UseCases/{$baseName}");
        $path = "{$dir}/{$baseName}ActionTest.php";

        if (! $filesystem->exists($path)) {
            $filesystem->ensureDirectoryExists($dir);

            $code = <<<PHP
                <?php

                declare(strict_types=1);

                namespace Tests\Unit\UseCases\\{$baseName};

                use App\UseCases\\{$baseName}\\{$baseName}Action;
                use Illuminate\Foundation\Testing\RefreshDatabase;
                use PHPUnit\Framework\Attributes\Test;
                use Tests\TestCase;

                class {$baseName}ActionTest extends TestCase
                {
                    use RefreshDatabase;

                    private \$action;

                    private \$expectedResultBase;

                    protected function setUp(): void
                    {
                        parent::setUp();
                        \$this->expectedResultBase = ['sample' => 1];
                        \$this->action = new {$baseName}Action();
                    }

                    #[Test]
                    public function サンプルが取得できること(): void
                    {
                        \$this->assertEquals(\$this->expectedResultBase, \$this->action->__invoke());
                    }
                }

                PHP;

            $filesystem->put($path, $code);
            $this->components->info("Created Unit Test: tests/Unit/UseCases/{$baseName}/{$baseName}ActionTest.php");
        }
    }
}
