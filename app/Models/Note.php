<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['title_note', 'text_note', 'date', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

     /* DATA CARBON */
     public function getDateNote()
     {
         if ($this->date) {
             return Carbon::create($this->date)->format('d-m-Y');
         }
     }
     public function getMonthDateNote()
     {
         if ($this->date) {
             return Carbon::create($this->date)->locale('it')->monthName;
         }
     }
     public function getDayWeekDateNote()
     {
         if ($this->date) {
             return Carbon::create($this->date)->locale('it')->dayName;
         }
     }
     public function getDayDateNote()
     {
         if ($this->date) {
             return Carbon::create($this->date)->locale('it')->day;
         }
     }
     public function getYearDateNote()
     {
         if($this->date){
             return Carbon::create($this->date)->locale('it')->year;
         }
     }
     public function getMonthsNote()
     {
         $months = collect(range(1, 12))->mapWithKeys(function ($monthNumber) {
             return [$monthNumber => Carbon::create()->month($monthNumber)->locale('it')->monthName];
         });
 
         return $months;
     }
}
