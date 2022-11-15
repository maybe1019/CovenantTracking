<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Client;

class Organization extends Model
{
    use HasFactory;

    //protected $table='organizations';

    protected $casts = [
    	'service_expiry_date' => 'date'
	];

	public function user()
	{
	    return $this->hasMany(User::class);
	}

	public function client()
	{
	    return $this->hasMany(Client::class);
	}
}
