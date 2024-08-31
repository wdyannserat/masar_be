<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SessionRate extends Pivot
{
    use HasFactory;

    protected $table = 'session_rates';

    protected $fillable = [
        'child_id',
        'program_session_id',
        'rate'
    ];

    //* Relations */
    //****** belongsTo Relations ******/

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function programSession()
    {
        return $this->belongsTo(ProgramSession::class, 'program_session_id');
    }

    ///****** hasMany Relations ******/

    ///****** Many to Many Relations ******/
}
