<?php

namespace App\Console\Commands;

use App\Traits\FileHelper;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use App\Traits\StringHelper;
use App\Console\Commands\RelationsGenerator;
use Nette\Utils\Arrays;

class MakeModuleCommand extends Command
{
    use StringHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new full module with full crud operations for an existing migration';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $tableName;
    protected $tableColumns = [];
    protected $mainOptions = ['f', 'fr', 'r'];
    protected $relations = "";
    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    ########################## General Helper Functions ##########################

    public function getClassNameFromTableName() //modelName
    {
        return Str::studly(Str::singular($this->tableName));
    }

    public function getPluralVarName()
    {
        return strtolower(Str::plural($this->tableName));
    }

    public function getSingularVarName()
    {
        return strtolower(Pluralizer::singular($this->tableName));
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    public function fillFile($filePath, $content)
    {
        if (!$this->files->exists($filePath)) {
            $this->files->put($filePath, $content);
            $this->info("File : {$filePath} created");
        } else {
            $this->info("File : {$filePath} already exits");
        }
    }

    public function getTablesWithColumns()
    {
        $migrationFiles = scandir(database_path('migrations'));
        $tables = [];

        foreach ($migrationFiles as $file) {
            if (strpos($file, '.php') !== false) {
                $path = database_path('migrations/' . $file);
                $content = file_get_contents($path);
                preg_match('/Schema::create\(\'(.+?)\',.+?\{(.+?)\}\);/s', $content, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    $tableName = $matches[1];
                    $columns = $matches[2];
                    preg_match_all('/\$table->(.+?)\(\'(.+?)\'.*?\);/', $columns, $matches2);
                    if (isset($matches2[1]) && isset($matches2[2])) {
                        $columnNames = $matches2[2];
                        $columnsArray = [];
                        foreach ($columnNames as $index => $name) {
                            $columnsArray[] = $name;
                        }
                        $tables[$tableName] = $columnsArray;
                    }
                }
            }
        }
        return $tables;
    }

    ########################## Stubs Helper Functions ##########################

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    public function getStubPath($stubType)
    {
        $stubPaths = [
            'controller'            => __DIR__ . '/../../../stubs/controller.crud.stub',
            'service'               => __DIR__ . '/../../../stubs/service.stub',
            // 'repository'            => __DIR__ . '/../../../stubs/repository.stub',
            'model'                 => __DIR__ . '/../../../stubs/model.with.fillable.stub',
            'request'               => __DIR__ . '/../../../stubs/request.filled.stub',
            'resource'              => __DIR__ . '/../../../stubs/resource.filled.stub',
            'factory'               => __DIR__ . '/../../../stubs/factory.filled.stub'
        ];
        return $stubPaths[$stubType];
    }


    public function getStubVariables($stubType, $columns = null)
    {
        $stubVars = [
            'controller'            =>  [
                'modelName'       => $this->getClassNameFromTableName(),
                'pluralModelVar'  => $this->getPluralVarName(),
                'modelVar'        => $this->getSingularVarName(),
                'objectPlural'    => ucwords(Str::plural($this->getClassNameFromTableName()))
            ],
            'service'               =>  [
                'modelName'     => $this->getClassNameFromTableName(),
                'modelVar'      => $this->getSingularVarName()
            ],
            // 'repository'            =>  [
            //     'modelName'     => $this->getClassNameFromTableName(),
            //     'modelVar'      => $this->getSingularVarName()
            // ],
            'model'                 =>  [
                'modelName'     => $this->getClassNameFromTableName(),
                'columns'       => $columns,
                'relationsFunctions' => $this->relations
            ],
            'request'               => [
                'modelName'     => $this->getClassNameFromTableName(),
                'columns'       => $columns
            ],
            'resource'              => [
                'modelName'     => $this->getClassNameFromTableName(),
                'columns'       => $columns
            ],
            'factory'               => [
                'modelName'     => $this->getClassNameFromTableName(),
                'columns'       => $columns
            ]
        ];
        return $stubVars[$stubType];
    }

    ######################################################################

    public function getSourceFilePath($fileName, $fileType)
    {
        $sourceFilesPaths = [
            'controller'            => base_path('App\\Http\\Controllers') . '\\' . $fileName . 'Controller.php',
            'service'               => base_path('App\\Services') . '\\' . $fileName . 'Service.php',
            // 'repository'            => base_path('App\\Repositories') . '\\' . $fileName . 'Repository.php',
            'model'                 => base_path('App\\Models') . '\\' . $fileName . '.php',
            'request'               => base_path('App\\Http\\Requests') . '\\' . $fileName . 'Request.php',
            'resource'              => base_path('App\\Http\\Resources') . '\\' . $fileName . 'Resource.php',
            'factory'               => database_path('factories') . '\\' . $fileName . 'Factory.php',
        ];
        return $sourceFilesPaths[$fileType];
    }

    ########################## Helper Functions For Model, Resource And FormRequest ##########################

    public function getReadyColumnsForModel()
    {
        $columnsString = "";
        for ($i = 0; $i < count($this->tableColumns); $i++) {
            if ($i != count($this->tableColumns) - 1) {
                if ($i == 0) {
                    $columnsString = $columnsString . "'" . $this->tableColumns[$i] . "',\n";
                } else {
                    $columnsString = $columnsString . "        '" . $this->tableColumns[$i] . "',\n";
                }
            } else {
                $columnsString = $columnsString . "        '" . $this->tableColumns[$i] . "'";
            }
        }
        return $columnsString;
    }

    public function getReadyColumnsForResource()
    {
        $columnsString = "'id' => \$this->id,\n";
        for ($i = 0; $i < count($this->tableColumns); $i++) {
            $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => \$this->" . $this->tableColumns[$i] . ",\n";
        }
        $columnsString = $columnsString . "            " .  "'created_at' => \$this->created_at";
        return $columnsString;
    }

    public function getReadyColumnsForRequestFactory()
    {
        $columnsString = "";
        for ($i = 0; $i < count($this->tableColumns); $i++) {
            if ($i != count($this->tableColumns) - 1) {
                if ($i == 0) {
                    $columnsString = $columnsString . "'" . $this->tableColumns[$i] . "' => '',\n";
                } else {
                    $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => '',\n";
                }
            } else {
                $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => ''";
            }
        }
        return $columnsString;
    }

    ########################## Main Functionality ##########################

    public function make($stubType)
    {
        $controllerName = $this->getClassNameFromTableName($this->tableName);
        $controllerPath = $this->getSourceFilePath($controllerName, $stubType);

        $readyColumns = null;
        if ($stubType == 'model') {
            $readyColumns = $this->getReadyColumnsForModel($this->tableColumns);
        }
        if ($stubType == 'request' || $stubType == 'factory') {
            $readyColumns = $this->getReadyColumnsForRequestFactory($this->tableColumns);
        }
        if ($stubType == 'resource') {
            $readyColumns = $this->getReadyColumnsForResource($this->tableColumns);
        }


        $this->makeDirectory(dirname($controllerPath));
        $content = $this->getStubContents(
            $this->getStubPath($stubType),
            $this->getStubVariables($stubType, $readyColumns)
        );

        $this->fillFile($controllerPath, $content);
    }



    public function makeRoutes()
    {
        $fileContents = File::get(base_path('routes/api.php'));
        $pattern = '/^\s*Route::group\(\[\s*\'prefix\'\s*=>\s*\'' . preg_quote('/' . $this->getPluralVarName(), '/') . '\'/m';
        if (!preg_match($pattern, $fileContents)) {
            $routes = '
Route::group([
    \'prefix\' => \'/' . $this->getPluralVarName() . '\',
    \'controller\' => ' . $this->getClassNameFromTableName() . 'Controller::class,
    // \'middleware\' => \'\'
], function () {
    Route::get(\'/\', \'getAll\');
    Route::get(\'/{id}\', \'find\');
    Route::post(\'/\', \'create\');
    Route::put(\'/{id}\', \'update\');
    Route::delete(\'/{id}\', \'delete\');
});
';
            File::append(base_path('routes/api.php'), $routes);
        }
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tablesWithColumns = $this->getTablesWithColumns();
        
        if (count($tablesWithColumns) != 0) {
            // $i = 1;
            // $tablesName = [];
            // foreach ($tablesWithColumns as $key => $value) {
            //     $tablesName[$i] = $key;
            //     printf($i . "- " . $key . "\n");
            //     $i++;
            // }

            // $selected = $this->ask("Select the table for which you want to create a module. optional(-f For Factory, -fr For FormRequest, -r For Resource)");

            // $input = explode('-', $selected);
            // $selectedTableIndex = $input[0];
            // $enteredOptions = [];

            // if (intval($selectedTableIndex) <= count($tablesName)) {
                foreach ($tablesWithColumns as $key => $value) {


                    // $this->tableName = $tablesName[intval($selectedTableIndex)];
                    $this->tableName = $key;
                    $this->tableColumns = $tablesWithColumns[$this->tableName];

                    // if (count($input) > 1) {
                    //     $enteredOptions = array_slice($input, 1, count($input) - 1);
                    //     if (count(array_intersect($this->mainOptions, $enteredOptions)) === count($enteredOptions)) {
                    //         foreach ($enteredOptions as $option) {
                    //             if ($option == 'f') {
                    //                 $this->make('factory');
                    //             } elseif ($option == 'fr') {
                    //                 $this->make('request');
                    //             } elseif ($option == 'r') {
                    //                 $this->make('resource');
                    //             }
                    //         }
                    //     } else {
                    //         printf('There is a wrong option');
                    //         return;
                    //     }
                    // }

                    $this->make('controller');
                    $this->make('service');
                    $this->make('request');
                    $this->make('resource');
                    // $this->make('repository');
                    $this->makeRoutes();

                    // $b = true;
                    $relationGenerator = new RelationsGenerator($this, $this->tableName);
                    $relationGenerator->setTableName($this->tableName);
                    /*do {
                    printf("1- belongsTo\n");
                    printf("2- belongsToMany\n");
                    printf("3- hasMany\n");
                    printf("4- HasOne\n");
                    printf("5- Exit\n");
                    $selectedRelation = $this->ask('select the relation');
                    switch (intval($selectedRelation)) {
                        case 1:
                            $relationGenerator->getBelongsToRelation();
                            break;
                        case 2:
                            $relationGenerator->getBelongsToManyRelation();
                            break;
                        case 3:
                            $relationGenerator->getHasManyRelation();
                            break;
                        case 4:
                            $relationGenerator->getHasOneRelation();
                            break;
                        case 5:
                            printf("5\n");
                            $b = false;
                            break;
                    }
                } while ($b);
                $this->relations = $relationGenerator->relations;
                */
                    $this->make('model');
                }
            // } else {
            //     printf('Incorrect selection');
            // }
        } else {
            printf('You don\'t have any migration yet...');
        }
    }
}
