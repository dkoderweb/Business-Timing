<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'name',
        'sunday_timing',
        'monday_timing',
        'tuesday_timing',
        'wednesday_timing',
        'thursday_timing',
        'friday_timing',
        'saturday_timing',
        'date_close',
        'images',
    ];
    protected $casts = [
        'sunday_timing' => 'json',
        'monday_timing' => 'json',
        'tuesday_timing' => 'json',
        'wednesday_timing' => 'json',
        'thursday_timing' => 'json',
        'friday_timing' => 'json',
        'saturday_timing' => 'json',
        'date_close' => 'json',
        'images' => 'json',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
    public function isClosedToday()
    {
        $currentDate = now()->format('Y-m-d');
    
        return  (is_array($this->date_close) && in_array($currentDate, $this->date_close));
    }    


    public function isDayClosed($day)
    {
        return $this->{$day . '_timing'}['closed'];
    }

    public function getFormattedTiming($day)
    {
        $timing = $this->{$day . '_timing'};

        if ($timing['closed']) {
            return 'Closed';
        }

        return implode(', ', array_map(function ($time) {
            return $time['start'] . ' - ' . $time['end'];
        }, $timing['timing']));
    }
}
