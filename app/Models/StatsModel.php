<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatsModel extends Model
{
    protected $table = "api_stats";
    protected $fillable = ['date','tested','confirmed','recovered','deaths'];
}
