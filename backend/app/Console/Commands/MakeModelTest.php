<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModelTest extends Command
{
    protected $signature = 'make:model-test {name}';

    protected $description = 'Unitテストクラスを models 用に作成します';

    public function handle(): void
    {
        $name = $this->argument('name');
        $class = Str::studly($name);
        $path = base_path("tests/Unit/Models/{$class}Test.php");

        if (File::exists($path)) {
            $this->error("{$class}Test.php は既に存在します。");

            return;
        }

        File::ensureDirectoryExists(dirname($path));

        File::put($path, <<<PHP
                          <?php

                          declare(strict_types=1);

                          namespace Tests\\Unit\\Models;

                          use App\\Models\\{$class};
                          use Illuminate\\Foundation\\Testing\\RefreshDatabase;
                          use PHPUnit\\Framework\\Attributes\\Test;
                          use Tests\\TestCase;

                          class {$class}Test extends TestCase
                          {
                              use RefreshDatabase;

                              #[Test]
                              public function モデルが作成できること(): void
                              {
                                  \$model = {$class}::factory()->create();
                                  \$this->assertDatabaseHas(\$model->getTable(), [
                                      'id' => \$model->id,
                                  ]);
                              }
                          }

                          PHP);
    }
}
