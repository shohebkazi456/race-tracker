<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Race extends Model
{
    protected $fillable = ['race_name','description'];
    public function checkpoints(): HasMany { return $this->hasMany(RaceCheckpoint::class)->orderBy('order_no'); }
    public function participants(): HasMany { return $this->hasMany(TeamMember::class)->whereNotNull('race_id'); }
}
