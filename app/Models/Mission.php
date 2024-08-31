<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'total_points',
        'number_of_challenges',
        'attachment_id',
        'is_active',
        'badge_url',
        'badge_name',
    ];
    //* Relations */
    //****** belongsTo Relations ******/
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
    //****** hasMany Relations ******/

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function missionProgram()
    {
        return $this->hasMany(MissionProgram::class);
    }

    //****** Many to Many Relations ******/

    public function programs()
    {
        return $this->belongsToMany(Program::class)->using(MissionProgram::class);
    }



    //**************************** */

    public function scopeInRunningProgram($query)
    {
        return $query->whereHas('programs',function($query) {
            $query->where('status', 'Running');
        });
    }
}
