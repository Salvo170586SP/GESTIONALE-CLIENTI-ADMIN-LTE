<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'end', 'start'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
