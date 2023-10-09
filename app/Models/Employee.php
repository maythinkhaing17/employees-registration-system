<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Employee
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 *
 */
class Employee extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'employees';
}
