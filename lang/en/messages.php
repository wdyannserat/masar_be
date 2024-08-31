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
    'AddedSuccessfully'                             => ':object Data added successfully',
    'UpdatedSuccessfully'                           => ':object Data updated successfully',
    'DataSuccessfullyFetched'                       => ':object Data fetched successfully',
    'DeletedSuccessfully'                           => ':object Data deleted successfully',
    'EmptyData'                                     => ':object Is Empty ',
    'UserIsAlreadyExist'                            => ':object already exists',
    'MissionAddedSuccessfullyToProgram'             => 'Missions added successfully for Current Program',
    'SessionsAddedSuccessfullyToProgram'            => 'Sessions added successfully for Current Program',
    'FacilitatorsAddedForGroupSuccessfully'         => 'Facilitators have been successfully assigned to the group',
    'ChildrenAddedForGroupSuccessfully'             => 'Children have been successfully assigned to the group',
    'ChallengeStartedSuccessfully'                  => 'Challenge started successfully',
    'ChildChallengeRequestHandledSuccessfully'      => 'Child Request Handled successfully',
    'ChildRemovedFromGroupSuccessfully'             => 'Child removed from group successfully',
    'ProgramEndedSuccessfully'                      => 'Program Ended Successfully',
    'SessionClosedSuccessfully'                     => 'Session Closed Successfully',
    // Auth Controller msgs
    'PasswordChangedSuccessfully'                   => 'Password changed successfully !',
    'UserInfoFetchedSuccessfully'                   => 'User Info Fetched Successfully .!',
    'UserSuccessfullyRegistered'                    => 'User successfully registered',
    'UserSuccessfullySignedIn'                      => 'User successfully signed in',
    'UserSuccessfullySignedOut'                     => 'User successfully signed out',

    //************************************************************Error Messages */

    // General Errors
    'ObjectNotFoundF'                               => ':object Not Found',
    'ObjectNotFound'                                => ':object Not Found',
    'ObjectAlreadyExist'                            => ':object already exist for :objectTwo',
    'DeletingFailed'                                => 'Deleting Failed',
    'NoPermission'                                  => 'You do not have permission',
    'RoleNotFound'                                  => 'Role not found',
    'FacilitatorDosntExists'                        => 'Facilitator for id :value dosnt exist',
    'ChildAlreadyExistInGroup'                      => 'Child with id :value already exists in group',
    'ChallengeAlreadyStarted'                       => 'You have been started this challenge already',
    'SessionNotFoundForThisGroupSchedule'           => 'Session not found for this group schedule',

    'YouCantDocumentChallenge'                      => 'You Can\'t Document Challenge',
    'RouteNotFound'                                 => 'Route Not Found',
    'SessionsIsNotInCurrentProgram'                 => 'One of The Sessions is not in Current Program',
    'SessionIsNotInCurrentProgram'                  => 'The Session is not in Current Program',
    // Auth Controller error msgs
    'newPasswordError'                              => 'New Password cannot be same as your current password. Please choose a different password.',
    'currentPasswordIncorrect'                      => 'Your current password does not matches with the password you provided. Please try again.',
    'passwordConfirmationNotMatch'                  => 'The Password confirmation does not match.',
    'Unauthenticated'                               => 'PLease login first',
    'ObjectNotActive'                               => 'The :object is Not Active',
    'userNotActive'                                 => 'The :object Account is not active',
    'Unauthorized'                                  => 'Error in Password',
    'ErrorInUserNameOrPhoneNumber'                  => 'Error in phone number or user name',
    'RequestHasAlreadyBeenSent'                     => 'Request has already been sent',
    'UserNameOrPhoneNumberAlreadyExist'             => 'user name or phone number already exists',
    'ChildDosntHaveThisSession'                     => 'The Child dosnt have a session for this question'

];
