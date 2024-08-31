<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserService extends BaseService
{
    public function getAll()
    {
        return  User::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();
        $user = User::create($validatedData);
        DB::commit();
        return $user;
    }

    public function show($id)
    {
        $user = $this->find($id);

        return $user;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $user = $this->find($id);

        $user->update($validatedData);

        DB::commit();
        return $user;
    }


    public function destroy($id)
    {
        $user = $this->find($id);

        DB::beginTransaction();


        $user->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(User::class, 'User', $id);
    }

    public function checkIfParentExists($phoneNumber)
    {
        return  User::where([
            'phone_number' => $phoneNumber,
            'role'         => 'Parent'
        ])->first();
    }
}
