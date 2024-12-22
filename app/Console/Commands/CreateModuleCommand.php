<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateModuleCommand extends Command
{

    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module';

    public function handle()
    {
        //
        $name = $this->argument('name');
        $pluralName = singularToPlural(strtolower($name));
        $modulePath = base_path("modules/$pluralName");

        $this->createDirectoryStructure($modulePath, $name);
        $this->createProvider($modulePath, $name);
        $this->createModel($modulePath, $name);
        $this->createController($modulePath, $name);
        $this->createRequest($modulePath, $name);
        $this->createRoutes($modulePath, $name);
        $this->createMigration($modulePath, $name);
        $this->createFactory($modulePath, $name);
        $this->createTest($name);

        $this->info("Module '$name' created successfully.");
    }

    private function createDirectoryStructure($path, $name)
    {
        $directories = [
            'App/Http/Controllers',
            'App/Http/Requests',
            'App/Models',
            'App/Providers',
            'database/migrations',
            'database/factories',
            'routes',
        ];

        foreach ($directories as $dir) {
            File::makeDirectory("$path/$dir", 0755, true);
        }

        $pluralName = singularToPlural(strtolower($name));
        File::makeDirectory("Tests/Feature/{$pluralName}", 0755, true);
    }

    private function createProvider($path, $name)
    {
        $lowerName = strtolower($name);
        $pluralName = singularToPlural($lowerName);
        $stub = File::get(__DIR__ . '/stubs/provider.stub');
        $content = str_replace(['{{pluralName}}'], [$pluralName], $stub);
        File::put("$path/App/Providers/ModuleServiceProvider.php", $content);
    }

    private function createTest($name)
    {
        $lowerName = strtolower($name);
        $pluralName = singularToPlural($lowerName);
        $stub = File::get(__DIR__ . '/stubs/test.stub');
        $content = str_replace(['{{ModuleName}}','{{pluralName}}','{{lowerName}}'], [$name,$pluralName,$lowerName], $stub);
        File::put("Tests/Feature/{$pluralName}/{$name}Test.php", $content);
    }

    private function createFactory($path, $name)
    {
        $lowerName = strtolower($name);
        $pluralName = singularToPlural($lowerName);
        $stub = File::get(__DIR__ . '/stubs/factory.stub');
        $content = str_replace(['{{ModuleName}}','{{pluralName}}'], [$name,$pluralName], $stub);
        File::put("$path/database/factories/{$name}Factory.php", $content);
    }

    private function createModel($path, $name)
    {
        $pluralName = singularToPlural(strtolower($name));
        $stub = File::get(__DIR__ . '/stubs/model.stub');
        $content = str_replace(['{{ModuleName}}','{{pluralName}}'], [$name,$pluralName], $stub);
        File::put("$path/App/Models/$name.php", $content);
    }

    private function createController($path, $name)
    {
        $lowerName = strtolower($name);
        $pluralName = singularToPlural($lowerName);
        $stub = File::get(__DIR__ . '/stubs/controller.stub');
        $content = str_replace(['{{ModuleName}}', '{{pluralName}}', '{{lowerName}}'], [$name, $pluralName, $lowerName], $stub);
        File::put("$path/App/Http/Controllers/{$name}Controller.php", $content);
    }

    private function createRequest($path, $name)
    {
        $lowerName = strtolower($name);
        $pluralName = singularToPlural($lowerName);
        $stub = File::get(__DIR__ . '/stubs/request.stub');
        $content = str_replace(['{{ModuleName}}', '{{pluralName}}'], [$name, $pluralName], $stub);
        File::put("$path/App/Http/Requests/{$name}Request.php", $content);
    }

    private function createRoutes($path, $name)
    {
        $pluralName = singularToPlural(strtolower($name));
        $stub = File::get(__DIR__ . '/stubs/api.stub');
        $content = str_replace(['{{ModuleName}}', '{{pluralName}}'], [$name, $pluralName], $stub);
        File::put("$path/routes/api.php", $content);
    }

    private function createMigration($path, $name)
    {
        $pluralName = singularToPlural(strtolower($name));
        $migrationName = date('Y_m_d_His') . "_create_{$pluralName}_table.php";
        $stub = File::get(__DIR__ . '/stubs/migration.stub');
        $content = str_replace('{{pluralName}}', $pluralName, $stub);
        File::put("$path/database/migrations/$migrationName", $content);
    }
}
