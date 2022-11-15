<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\standardCovenant;

class childCovenant extends Model
{
    use HasFactory;

    public function standardCovenant()
    {
        return $this->belongsTo(standardCovenant::class);
    }
}
