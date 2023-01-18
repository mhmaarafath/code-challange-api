<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['days'];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    protected function days(): Attribute
    {
        return new Attribute(
            get: function (){
                return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
            }
        );
    }
}
