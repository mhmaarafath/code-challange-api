<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['leaves_available', 'total_working_hours'];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    protected function profilePhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => image($value),
        );
    }
    public function leaves(){
        return $this->hasMany(Leave::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    protected function leavesAvailable(): Attribute
    {
        return new Attribute(
            get: function (){
                $difference = Carbon::parse($this->contract_start_date)->diffInDays(Carbon::now());

                if($difference <= 60){
                    return -1;
                } else {
                    $totalLeaves = floor(($difference - 60) / 30) * 2.5;
                    $leavesTaken = $this->leaves->sum('days');
                    return $totalLeaves - $leavesTaken;
                }

            }
        );
    }

    protected function totalWorkingHours(): Attribute{
        return new Attribute(
            get: function (){
                return $this->attendances->sum('hours');
            }
        );

    }
}
