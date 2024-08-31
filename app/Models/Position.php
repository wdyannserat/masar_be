<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'name',
        'latitude',
        'longitude',
        'notes'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    //****** hasMany Relations ******/

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function positionTrip()
    {
        return $this->hasMany(PositionTrip::class);
    }

    //****** Many to Many Relations ******/

    public function trips()
    {
        return $this->belongsToMany(Trip::class)->using(PositionTrip::class);
    }
}
