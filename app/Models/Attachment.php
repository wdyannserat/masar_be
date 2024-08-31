<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    //****** hasMany Relations ******/

    public function files()
    {
        return $this->hasMany(File::class);
    }

    //****** Many to Many Relations ******/
}