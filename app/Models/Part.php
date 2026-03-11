<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = [
        'name',
        'code',
        'supplier',
        'quantity',
    ];

    public function repairParts()
    {
        return $this->hasMany(RepairPart::class);
    }
}