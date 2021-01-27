<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['name','email','job','department'];
}
