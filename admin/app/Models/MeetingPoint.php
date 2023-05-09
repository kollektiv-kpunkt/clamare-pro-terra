<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingPoint extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'meeting_time',
        'approved',
        'user_id',
        'latitude',
        'longitude',
        'type'
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'approved' => 'boolean',
        "latitude" => "double",
        "longitude" => "double",
        "meeting_time" => "datetime"
    ];

    /**
     * Get the user that owns the MeetingPoint
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
