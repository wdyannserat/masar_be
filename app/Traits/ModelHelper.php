<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Lang;

trait ModelHelper
{
    protected static function findByIdOrFail($modelName, $object, $modelId, $type = 'male')
    {
        $model = $modelName::find($modelId);

        if (!$model) {
            $objectType = '';
            if ($type == 'female') {
                $objectType = 'messages.ObjectNotFoundF';
            } else {
                $objectType = 'messages.ObjectNotFound';
            }
            throw new Exception(__($objectType, ['object' => __('objects.' . $object)]), 404);
        }
        return $model;
    }
}
