<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $fillable = ['project','active','status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
