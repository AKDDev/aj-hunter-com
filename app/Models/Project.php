<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['project','active','status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeActive($query) {
        return $query->where('active','=',1);
    }
}
