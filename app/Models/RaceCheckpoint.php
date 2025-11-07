<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RaceCheckpoint extends Model
{
    protected $fillable = ['race_id','checkpoint_name','order_no'];
    public function race(): BelongsTo { return $this->belongsTo(Race::class); }
    public function logs(): HasMany { return $this->hasMany(RaceLog::class, 'checkpoint_id'); }
}
