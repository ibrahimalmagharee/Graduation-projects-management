<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $table = 'advertises';
    protected $fillable = ['title','description','advertise_file','publish_date'];
}
