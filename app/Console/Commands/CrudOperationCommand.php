<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CrudOperationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD Operations for Model (Resources|Requests|Controllers|Models)';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/crud_operation.stub';
    }


    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'namespace'         => 'App\\Http\\Controllers',
            'rootNamespace'     => 'App\\',
            'class'             => $this->getSingularClassName($this->argument('name')) . 'Controller',
            'modelName'         => $this->argument('name'),
            'objectPlural'      => ucwords(Str::plural($this->argument('name'))),
            'modelVar'          => '$' . strtolower($this->argument('name')),
            'serviceVar'        => strtolower($this->argument('name')).'Service',
            'serviceClass'      => $this->getSingularClassName($this->argument('name')) . 'Service',
            'serviceVarWithDollarSign'   => '$' . strtolower($this->argument('name')).'Service',
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('App\\Http\\Controllers') . '\\' . $this->getSingularClassName($this->argument('name')) . 'Controller.php';
    }


    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }








    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
        $modelName = $this->argument('name');
        $routeModelPathName = Str::lower(Str::plural($modelName));
        Artisan::call('make:model -mf ' . $modelName);
        Artisan::call('make:crud_service ' . $modelName);
        Artisan::call('make:resource ' . $modelName . 'Resource');
        Artisan::call('make:request ' . $modelName . 'Request');
        $routes = '
Route::group([\'prefix\' => \'/'.$routeModelPathName.'\', \'controller\' => '.$modelName.'Controller::class], function () {
    Route::post(\'/\', \'store\')->name(\''.$routeModelPathName.'_store\');
    Route::get(\'/\', \'index\')->name(\''.$routeModelPathName.'_index\');
    Route::put(\'/{id}\', \'update\')->name(\''.$routeModelPathName.'_update\');
    Route::get(\'/\', \'show\')->name(\''.$routeModelPathName.'_show\');      //*pass id using query params
    Route::delete(\'/{id}\', \'destroy\')->name(\''.$routeModelPathName.'_delete\');
});
';
        File::append(base_path('routes/api.php'),$routes);
    }
}