<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
abstract class Dao extends Model
{
    public $timestamps = false;
}
