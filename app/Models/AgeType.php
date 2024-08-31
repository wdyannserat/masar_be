<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'age_type',
        'ages',
        'min_age',
        'max_age',
        'notes'
    ];
    protected $casts = [
        'ages' => 'array'
    ];

    //* Relations */
    //****** belongsTo Relations ******/

    //****** hasMany Relations ******/

    public function groups()
    {
        return $this->hasMany(Group::class, 'age_type_id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'age_type_id');
    }

    //****** Many to Many Relations ******/
}
