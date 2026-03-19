<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'tenant_id';

    protected $fillable = [
        'tenant_id',
        'school_name',
        'last_name',
        'address',
    ];
}
