<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_client',
        'surname_client',
        'date_of_birth',
        'city_of_birth',
        'address',
        'cap',
        'file_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }


    /* DATA CARBON */
    public function getDate()
    {
        if ($this->date) {
            return Carbon::create($this->date)->format('d-m-Y');
        }
    }
    public function getMonthDate()
    {
        if ($this->date) {
            return Carbon::create($this->date)->locale('it')->monthName;
        }
    }
    public function getDayWeekDate()
    {
        if ($this->date) {
            return Carbon::create($this->date)->locale('it')->dayName;
        }
    }
    public function getDayDate()
    {
        if ($this->date) {
            return Carbon::create($this->date)->locale('it')->day;
        }
    }
    public function getYearDate()
    {
        if($this->date){
            return Carbon::create($this->date)->locale('it')->year;
        }
    }
    public function getMonths()
    {
        $months = collect(range(1, 12))->mapWithKeys(function ($monthNumber) {
            return [$monthNumber => Carbon::create()->month($monthNumber)->locale('it')->monthName];
        });

        return $months;
    }
}
