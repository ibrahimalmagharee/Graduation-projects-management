<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'discussions';
    protected $fillable = ['group','discussion_date','discussion_time','discussion_place','discussant'];
}
