<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['goal','project_id','status_id','total','type_id','start','end'];
}
