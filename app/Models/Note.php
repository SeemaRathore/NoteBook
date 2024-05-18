<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{

    protected $fillable = [
        'title', 'description', 'cover_photo'
    ];



    public function owner():BelongsTo{
        return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

}
