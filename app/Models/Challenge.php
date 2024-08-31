<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points',
        'is_timed',
        'duration_in_days',
        'duration_in_hours',
        'mission_id',
        'attachment_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }


    //****** hasMany Relations ******/

    public function challengeChild()
    {
        return $this->hasMany(ChallengeChild::class);
    }

    //****** Many to Many Relations ******/

    public function children()
    {
        return $this->belongsToMany(Child::class)
            ->using(ChallengeChild::class)->withPivot(
                'progress',
                'status',
                'attachment_id'
            );
    }

    public function isActive(){
        return $this->status == 'Active';
    }
}
