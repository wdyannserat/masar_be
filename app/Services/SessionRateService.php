<?php

namespace App\Services;

use App\Models\ProgramSession;
use App\Models\SessionRate;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SessionRateService extends BaseService
{
    public function getAll()
    {
        return  SessionRate::all();
    }


    public function store($validatedData, $sessionId)
    {
        DB::beginTransaction();
        $validatedData['child_id'] = Auth::guard('children')->id();
        $programSession = ProgramSession::getCurrentProgramSession($sessionId);

        if ($programSession == null) {
            throw new Exception(__('messages.SessionIsNotInCurrentProgram'), 400);
        }
        $validatedData['program_session_id'] = $programSession->id;
        $sessionRate = SessionRate::create($validatedData);
        DB::commit();
        return $sessionRate;
    }

    public function show($id)
    {
        $sessionRate = $this->find($id);

        return $sessionRate;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $sessionRate = $this->find($id);

        $sessionRate->update($validatedData);

        DB::commit();
        return $sessionRate;
    }


    public function destroy($id)
    {
        $sessionRate = $this->find($id);

        DB::beginTransaction();


        $sessionRate->delete();
        DB::commit();

        return true;
    }

    public static function find($id)
    {
        return parent::findByIdOrFail(SessionRate::class, 'SessionRate', $id);
    }
}
