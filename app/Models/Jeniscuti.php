<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jeniscuti extends Model
{
    public function cutis(): HasMany
    {
        return $this->HasMany(cuti::class);
    }
}
