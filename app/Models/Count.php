<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Count extends Model
{
    use HasFactory;

    public $fillable = ['goal_id','value','when','comment','type_id'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
