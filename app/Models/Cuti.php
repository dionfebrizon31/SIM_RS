<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuti extends Model
{
    public function Users(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
    public function jeniscutis(): BelongsTo
    {
        return $this->BelongsTo(JenisCuti::class);  // Misalnya Cuti punya banyak JenisCuti
    }
}
