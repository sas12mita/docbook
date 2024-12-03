<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if follows conventions)
    protected $table = 'schedules';

    // Define fillable attributes
    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'day',
        'status',
    ];

    // Define the relationship with the Doctor model
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // You can define other methods to get formatted date or time, etc.
    public function getFormattedDate()
    {
        return \Carbon\Carbon::parse($this->date)->format('F j, Y');
    }

    public function getStartTimeFormatted()
    {
        return \Carbon\Carbon::parse($this->start_time)->format('h:i A');
    }

    public function getEndTimeFormatted()
    {
        return \Carbon\Carbon::parse($this->end_time)->format('h:i A');
    }
}
