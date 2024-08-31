<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChallengeChild extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'progress',
        'status',
        'description',
        'challenge_id',
        'child_id',
        'attachment_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}