<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\childCovenant;
use App\Models\failedCovenant;

class standardCovenant extends Model
{
    use HasFactory;

        protected $fillable = [
        'type',
    ];

    public function childCovenant()
	{
	    return $this->hasMany(childCovenant::class);
	}

	public function failedCovenant()
	{
	    return $this->hasMany(failedCovenant::class);
	}
}
