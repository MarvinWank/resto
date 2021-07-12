<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Database\Eloquent\Model;

class SaveException extends Exception
{

    public static function failedSavingModel(Model $model, \Throwable  $throwable)
    {
        return new self(
            "Failed saving Model of table " . $model->getTable() .
            " Message: " . $throwable->getMessage()
        );
    }

}
