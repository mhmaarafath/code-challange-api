<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['hours'];

    protected function hours(): Attribute
    {
        return new Attribute(
            get: function (){
                return Carbon::parse($this->checkin)->diffInHours(Carbon::parse($this->checkout));
            }
        );
    }

}
