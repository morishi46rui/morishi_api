<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Str;

class MakeModelWithSchema extends ModelMakeCommand
{
    protected $name = 'make:schemamodel';

    protected function getStub()
    {
        return base_path('stubs/model.stub');
    }

    protected function buildClass($name)
    {
        $stub = file_get_contents($this->getStub());

        $className = class_basename($name);
        $namespace = $this->getNamespace($name);
        $schemaName = Str::camel($className);

        return str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ schema_name }}'],
            [$namespace, $className, $schemaName],
            $stub
        );
    }
}
