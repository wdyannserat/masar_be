<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    //************************************************************Success Messages */

    // General msgs
    'AddedSuccessfully'                         => 'تمت إضافة بيانات :object بنجاح',
    'UpdatedSuccessfully'                       => 'تم تعديل بيانات :object بنجاح',
    'DataSuccessfullyFetched'                   => 'تم جلب بيانات :object بنجاح',
    'DeletedSuccessfully'                       => 'تم حذف بيانات :object بنجاح',
    'EmptyData'                                 => ':object خالية',
    'AlreadyExist'                              => ':object موجود بالفعل',
    'MissionAddedSuccessfullyToProgram'         => 'تم إسناد المهام للبرنامج الحالي بنجاح',
    'SessionsAddedSuccessfullyToProgram'        => 'تم إسناد الجلسات للبرنامج الحالي بنجاح',
    'FacilitatorsAddedForGroupSuccessfully'     => 'تم إسناد الميسرين للمجموعة بنجاح ',
    'ChildrenAddedForGroupSuccessfully'         => 'تم إسناد الأطفال للمجموعة بنجاح',
    'ChildRemovedFromGroupSuccessfully'         => 'تمت إزالة الطفل من المجموعة بنجاح',

    'ChallengeStartedSuccessfully'              => 'تم بدء التحدي بنجاح',
    'ChildChallengeRequestHandledSuccessfully'  => 'تمت معالجة طلب الطفل بنجاح',
    'ProgramEndedSuccessfully'                  => 'تم إنهاء البرنامج بنجاح',
    'SessionClosedSuccessfully'                 => 'تم إنهاء الجلسة بنجاح',
    // Auth Controller msgs
    'PasswordChangedSuccessfully'               => 'تم تغيير كلمة المرور بنجاح',
    'UserSuccessfullyRegistered'                => 'تم تسجيل المستخدم بنجاح',
    'UserInfoFetchedSuccessfully'               => 'تم جلب بيانات المستخدم بنجاح',
    'UserSuccessfullySignedIn'                  => 'تم تسجيل الدخول بنجاح',
    'UserSuccessfullySignedOut'                 => 'تم تسجيل الخروج بنجاح',

    //************************************************************Error Messages */

    // General Errors
    'ObjectNotFoundF'                           => ':object غير موجودة',
    'ObjectNotFound'                            => ':object غير موجود',
    'ObjectAlreadyExist'                        => '  :object  موجود مسبقا ل :objectTwo ',
    'DeletingFailed'                            => 'فشلت عملية الحذف',
    'NoPermission'                              => 'لا تملك صلاحيات',
    'RoleNotFound'                              => 'هذا الدور غير موجود',
    'FacilitatorDosntExists'                    => 'الميسر ذو الرقم :value غير موجود',
    'ChildAlreadyExistInGroup'                  => 'الطفل رقم :value موجود مسبقا ضمن المجموعة',
    'SessionNotFoundForThisGroupSchedule'       => 'لا يوجد جلسة مسندة للمجموعة في هذا التاريخ ',
    'ChallengeAlreadyStarted'                   => 'لقد قمت ببدء التحدي مسبقا',
    'YouCantDocumentChallenge'                  => 'لا يمكنك توثيق هذا التحدي',
    'RouteNotFound'                             => 'المسار غير موجود',
    'ObjectNotActive'                           => ':object غير مفعل',
    'SessionsIsNotInCurrentProgram'             => 'أحد الجلسات  ليست موجودة ضمن البرنامج الحالي ',
    'SessionIsNotInCurrentProgram'              => 'الجلسة  ليست موجودة ضمن البرنامج الحالي ',
    // Auth Controller error msgs
    'newPasswordError'                          => 'كلمة المرور الجديدة لا يمكن ان تكون مماثلة للقديمة . يرجى إعادة المحاولة',
    'currentPasswordIncorrect'                  => 'كلمة المرور الحالية لا تتطابق مع التي تم ادخالها. يرجى إعادة المحاولة',
    'passwordConfirmationNotMatch'              => 'تأكيد كلمة المرور غير متطابقة. يرجى إعادة المحاولة',
    'Unauthorized'                              => 'خطأ في كلمة المرور',
    'userNotActive'                             => 'حساب ال :object غير فعال',
    'Unauthenticated'                           => 'الرجاء تسجيل الدخول اولاً',
    'ErrorInUserNameOrPhoneNumber'              => 'خطأ في اسم المستخدم او رقم الهاتف',
    'AlreadyHandled'                            => 'تمت معالجة الطلب من قبل ',
    'RequestHasAlreadyBeenSent'                 => 'تم إرسال الطلب مسبقاً',
    'UserNameOrPhoneNumberAlreadyExist'         => 'اسم المستخدم أو رقم الهاتف موجود مسبقاً',
    'ChildDosntHaveThisSession'                 => 'الطفل ليس لديه جلسة تخص هذا السؤال'
];
