<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'file_path',
        'description',
        'order',
        'attachment_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}