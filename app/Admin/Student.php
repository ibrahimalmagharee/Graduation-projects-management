<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['student_id','name','email','specialization','level'];


}
