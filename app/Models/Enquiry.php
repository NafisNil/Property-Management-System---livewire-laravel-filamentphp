<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    /** @use HasFactory<\Database\Factories\EnquiryFactory> */
    use HasFactory;
    protected $fillable = ['property_id', 'name', 'email', 'phone', 'message', 'status'];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
