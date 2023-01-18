<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function company(){
        return $this->belongsTo(Company::class);
    }

    protected function profilePhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => image($value),
        );
    }
}
