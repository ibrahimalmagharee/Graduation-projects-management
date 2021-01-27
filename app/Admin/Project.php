<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['title','programming_type','suggester','description','publish_date'];
}
