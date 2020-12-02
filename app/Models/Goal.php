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

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function count() {
        return $this->hasMany(Count::class);
    }

    public function scopeActive($query)
    {
        $today = now()->toDateString();
        return $query->where('start','<=',$today)
            ->where(function($query) use ($today) {
                $query->whereNull('end')
                    ->orWhere('end','>=',$today);
            });
    }
}
