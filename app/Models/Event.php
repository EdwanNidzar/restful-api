<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_date',
        'event_time',
        'event_name',
        'event_description',
        'event_location',
        'event_address',
        'event_image',
        'event_organization',
        'event_contact',
        'event_status',
        'submission_status',
        'notes',
    ];

    protected function image(): Attribute{
        return Attribute::make(
            get: fn ($iamge) => asset('storage/events/' . $iamge),
        );
    }
}
