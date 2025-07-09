<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $table = "tl_plugins";

    protected $fillable = array('name');
}
