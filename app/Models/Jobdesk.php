<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jobdesk extends Model
{
    public $timestamps = false;
    protected $with = ['Jabatans'];
    
    public function jabatans():BelongsTo
    {
        return $this->BelongsTo(Jabatans::class);
    }
}
