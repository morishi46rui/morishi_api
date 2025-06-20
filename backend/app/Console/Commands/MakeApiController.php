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
}
