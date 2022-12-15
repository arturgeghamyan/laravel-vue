<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Use Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id'
    ];


    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'ticket_users');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
    // }
}
