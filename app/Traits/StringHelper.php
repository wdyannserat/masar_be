<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Pluralizer;

trait StringHelper
{
    public function getModelNameFromTableName($name)
    {
        return Str::studly(Str::singular($name));
    }

    public static function getPluralVarName($name)
    {
        return strtolower(Str::plural($name));
    }

    public static function getSingularVarName($name)
    {
        return strtolower(Pluralizer::singular($name));
    }

    public function generateUserName($type, $name): string
    {
        $userName = strtolower(str_replace(' ', '_', $name));
        $types = [
            'Facilitator'   => 'fa',
            'Child'         => 'ch',
            'Parent'        => 'pa',
        ];

        //TODO generate new rule for generate username
        return $userName . '_' . $types[$type] . Str::random(3);
    }
}
