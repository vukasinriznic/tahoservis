<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'service_request_id',
        'work_done',
        'seal_number',
        'pdf_path',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function repairParts()
    {
        return $this->hasMany(RepairPart::class);
    }
}