<?php

namespace App\Services;

use App\Http\Resources\ChildResource;
use App\Http\Resources\UserResource;
use App\Models\Child;
use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService extends BaseService
{
    public function __construct(
        private ChildService $childService,
        private AttachmentService $attachmentService
    ) {
    }

    public function userLogin($validatedData)
    {
        $user = User::where('username', $validatedData['username_or_phone_number'])
            ->orWhere('phone_number', $validatedData['username_or_phone_number'])->first();

        if (!isset($user)) {
            throw new Exception(__('messages.ErrorInUserNameOrPhoneNumber'), 401);
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            throw new Exception(__('auth.password_failed'), 401);
        }

        if (!$user->isActive()) {
            throw new Exception(__('messages.userNotActive', ['object' => __('objects.User')]), 403);
        }
        $token = $user->createToken(config('sanctum.secret_key'))->plainTextToken;

        return [
            'token' => $token,
            'user' => $this->resource($user, UserResource::class)
        ];
    }

    public function childLogin($validatedData)
    {
        $child = Child::where('username', $validatedData['username'])->first();

        if (!isset($child)) {
            throw new Exception(__('auth.username_failed'), 401);
        }
        if (!Hash::check($validatedData['password'], $child->password)) {
            throw new Exception(__('auth.password_failed'), 401);
        }
        if (!$child->isActive()) {
            throw new Exception(__('messages.userNotActive', ['object' => __('objects.Child')]), 403);
        }

        $token = $child->createToken(config('sanctum.secret_key'), ['children'])->plainTextToken;

        return [
            'token' => $token,
            'child' => $this->resource($child, ChildResource::class)
        ];
    }

    public function userInfo()
    {
        return Auth::user();
    }

    public function logout()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
    }

    public function updateParentPassword($validatedData)
    {
        if (!Hash::check($validatedData['old_password'], Auth::guard('users')->user()->password)) {
            throw new Exception(__('messages.currentPasswordIncorrect'));
        }

        if (Hash::check($validatedData['new_password'], Auth::guard('users')->user()->password)) {
            throw new Exception(__('messages.newPasswordError'));
        }
        DB::beginTransaction();
        /**
         * @var App\Models\User $user
         */
        $user  = Auth::guard('users')->user();

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();
        // $user->tokens()->delete();
        DB::commit();
    }

    public function updateChildProfile($validatedData)
    {
         DB::beginTransaction();
        /**
         * @var App\Models\Child $child
         */
        $child = Auth::guard('children')->user();
        $filePath = null;

        if (isset($validatedData['photo'])) {
            $filePath = $this->uploadFile($validatedData['photo'], 'child_files/');
        }

        if ($filePath != null & isset($child->attachment_id)) {
            $file = $child->attachment->files->first();
            if (isset($file)) {
                $file->update([
                    'file' => $filePath
                ]);
            }
        } else {
            $fileArrays = [];
            $fileArrays[0]['file'] = $validatedData['photo'];

            $attachment = $this->attachmentService->store([
                'files' =>  $fileArrays
            ], 'Child_Info');
            if (!isset($attachment)) {
                throw new Exception('Error in create Attachment', 400);
            }
            $validatedData['attachment_id'] = $attachment->id;
        }

        $child->update($validatedData);
        DB::commit();
        return true;
    }

    public function updateAccountStatus($validatedData)
    {
        DB::beginTransaction();
        $account = null;
        if ($validatedData['account_type'] == 'User') {
            $account = $this->find($validatedData['account_id']);
        } else if ($validatedData['account_type'] == 'Child') {
            $account = $this->childService->find($validatedData['account_id']);
        }

        $account->update([
            'is_active' => $validatedData['is_active']
        ]);
        DB::commit();
    }



    public function find($id)
    {
        return $this->findByIdOrFail(User::class, 'User', $id);
    }
}
