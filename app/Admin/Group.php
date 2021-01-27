<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = ['group_number','student','project','supervisor'];
}
