<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
