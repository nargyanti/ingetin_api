<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';

    protected $fillable = [            
        'name',
        'course',
        'description',
        'submit_location',
        'due_date',
        'due_time',
        'level',
        'estimation',      
        'status',  
    ];

    public function user() 
    {        
        return $this->belongsTo(User::class);
    }

    public function getRemainingHoursAttribute()
    {
        if ($this->due_date) {
            $time_remaining = Carbon::now()->diffInDays(Carbon::parse($this->due_date));
        } else {
            $time_remaining = 0;
        }
        return $time_remaining;
    }
}
