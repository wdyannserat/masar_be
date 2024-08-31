<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'session_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}