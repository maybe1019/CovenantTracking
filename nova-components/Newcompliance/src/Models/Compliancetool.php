<?php

namespace Axis\Newcompliance\Models;
use App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliancetool extends Model
{
	use HasFactory;

	protected $table='compliances';

	protected $guarded = [];

	protected $fillable = [
        'clcode', 
        'isin',
        'docName',
        'startDate',
        'endDate',
        'priority',
        'secured',
        'inconsistencyTreatment',
		'clientReference',
        'mailCC',
        'documentNames',
        'userId',
    ];
}