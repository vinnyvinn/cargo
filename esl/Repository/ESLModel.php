<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 4/6/18

 */

namespace Esl\Repository;


use Esl\Traits\EslTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class ESLModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
