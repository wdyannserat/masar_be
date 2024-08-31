<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\{
    AuthController,
    ItemController,
    TripController,
    ChildController,
    GroupController,
    AnswerController,
    SurveyController,
    AgeTypeController,
    ConceptController,
    MissionController,
    ProgramController,
    SessionController,
    PositionController,
    QuestionController,
    ChallengeController,
    SurveyUserController,
    ItemRequestController,
    PositionTripController,
    GroupScheduleController,
    ChallengeChildController,
    FacilitatorTripController,
    ChildTripChecklistController,
    SessionChecklistController,
    FacilitatorController,
    FormController,
    SessionRateController,
    SuggestedAnswerController
};
//*Auth Users routes
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group([
        'controller' => AuthController::class,
        'prefix'     => '/auth'
    ], function () {
        Route::get('/user', 'userInfo')->name('user_info');
        Route::delete('/logout', 'logout')->name('logout');
        Route::post('/update-password', 'updateParentPassword')->middleware('role:Parent')->name('update_parent_password');
        Route::post('/update-account-status', 'updateAccountStatus')->middleware('role:Admin|Manager')->name('update_account_status');
        Route::post('/child/update-profile', 'updateChildProfile')->middleware('role:Child')->name('update_child_profile');
    });

    Route::group([
        'controller' => AgeTypeController::class,
        'prefix'     => '/age-types',
        'middleware' => 'role:Admin|Manager'
    ], function () {
        Route::get('/all', 'index')->name('age_types_index');
        Route::get('/', 'show')->name('age_types_show');
        Route::post('/', 'store')->name('age_types_store');
        Route::post('/{id}', 'update')->name('age_types_update');
        Route::delete('/{id}', 'destroy')->name('age_types_delete');
    });

    Route::group([
        'controller' => ProgramController::class,
        'prefix'     => '/programs',
        'middleware' => 'role:Manager|Admin'
    ], function () {
        Route::get('/{id}/groups', 'getGroupsByProgramId')->name('groups_for_program');
        Route::get('/all', 'index')->name('programs_index');
        Route::get('/requests', 'getProgramsRequests')->middleware('role:Manager')->name('get_programs_requests');
        Route::get('/', 'show')->name('programs_show');

        Route::post('/', 'store')->name('programs_store');
        Route::post('/{id}/end-program', 'endProgram')->middleware('role:Manager')->name('end_program');
        Route::post('/{id}/assign-sessions', 'assignSessions')->name('programs_assign_sessions');
        Route::post('/{id}/assign-missions', 'assignMissions')->name('programs_assign_missions');
        Route::post('/{id}', 'update')->middleware('role:Manager')->name('programs_update');

        Route::delete('/{id}', 'destroy')->middleware('role:Manager')->name('programs_delete');
    });

    Route::group([
        'controller' => ChildController::class,
        'prefix'     => '/children'
    ], function () {
        Route::get('/', 'show')->name('children_show');      //*pass id using query params
        Route::get('/all', 'index')->middleware('role:Admin')->name('children_index');
        Route::get('/get-details-sessions-missions', 'getChildInfoDetails')->name('child_sessions_missions_badges');
        Route::post('/', 'store')->middleware('role:Admin')->name('children_store');
        Route::post('/{id}', 'update')->middleware('role:Admin')->name('children_update');
        Route::delete('/{id}', 'destroy')->middleware('role:Admin')->name('children_delete');
    });

    Route::group([
        'controller' => GroupController::class,
        'prefix'     => '/groups',
        'middleware' => 'role:Admin|Manager|Facilitator'
    ], function () {
        Route::get('/all', 'index')->name('groups_index');
        Route::get('/', 'show')->name('groups_show');      //*pass id using query params

        Route::group(['middleware' => 'role:Admin|Manager'], function () {
            Route::post('/', 'store')->name('groups_store');
            Route::post('/{id}/assign-facilitators', 'assignFacilitators')->name('groups_assign_facilitators');
            Route::post('/{id}/assign-children', 'assignChildren')->name('groups_assign_children');
            Route::post('/{id}', 'update')->name('groups_update');
            Route::delete('/{id}/children/{childId}/delete-from-group', 'deleteChildFromGroup')->name('groups_delete_child');
            Route::delete('/{id}', 'destroy')->name('groups_delete');
        });
    });

    Route::group([
        'controller' => GroupScheduleController::class,
    ], function () {
        //
        Route::post('/groups/{groupId}/group-schedules', 'store')->name('group_schedules_store');
        Route::group(['prefix' => '/group-schedules'], function () {
            Route::get('/{groupScheduleId}/session', 'getSessionForGroupSchedule');
            Route::get('/all', 'index')->name('group_schedules_index');
            Route::get('/', 'show')->name('group_schedules_show');      //*pass id using query params
            Route::post('/{id}/assign-session', 'assignSessions')->middleware('role:Admin|Manager')->name('assign_sessions_to_group_schedule');
            Route::post('/{id}', 'update')->name('group_schedules_update');
            Route::delete('/{id}', 'destroy')->name('group_schedules_delete');
        });
    });


    Route::group([
        'controller' => FacilitatorController::class,
        'prefix'     => 'facilitators',
    ], function () {
        Route::post('/manage-challenge-request', 'mangeChallengeRequest')->middleware('role:Facilitator')->name('facilitator_manage_challenge_request');
        Route::get('/challenge-confirm-request', 'getChallengeConfirmRequests')->middleware('role:Facilitator')->name('get_challenge_confirm_requests');
        Route::get('/get-my-groups', 'getMyGroups')->middleware('role:Facilitator')->name('get_my_groups');

        Route::group(['middleware' => 'role:Admin|Manager'], function () {
            Route::post('/', 'store')->name('facilitators_store');
            Route::post('/{id}', 'update')->name('facilitators_update');
            Route::get('/all', 'index')->name('facilitators_index');
            Route::get('/', 'show')->name('facilitators_show');      //*pass id using query params
            Route::delete('/{id}', 'destroy')->name('facilitators_delete');
        });
    });

    Route::group([
        'controller' => MissionController::class,
        'prefix' => '/missions',
    ], function () {
        Route::get('/all', 'index')->name('missions_index');
        Route::get('/', 'show')->name('missions_show');      //*pass id using query params
// <<<<<<< HEAD
//         Route::get('/with_challenge', 'showAllWithChallenge');
//         Route::post('/', 'store')->name('missions_store');//->middleware('role:Admin|Manager');
// =======
//         Route::get('/for-current-program', 'getCurrentProgramMissions')->name('current_program_missions');

//         Route::post('/', 'store')->name('missions_store')->middleware('role:Admin|Manager');
// >>>>>>> e13de071073239a97ff1a1ecb7637b7532ac414c
        Route::post('/{id}', 'update')->name('missions_update')->middleware('role:Admin|Manager');

        Route::delete('/{id}', 'destroy')->name('missions_delete')->middleware('role:Admin|Manager');
    });


    Route::group([
        'controller' => ChallengeController::class,
        'prefix' => '/challenges',
    ], function () {
        //TODO! check these routes in postman
        Route::get('/all', 'index')->name('challenges_index');
        Route::get('/', 'show')->name('challenges_show');      //*pass id using query params
        Route::post('/', 'store')->name('challenges_store');
        Route::post('/{id}', 'update')->name('challenges_update');
        Route::delete('/{id}', 'destroy')->name('challenges_delete');
        Route::post('/{id}/start-challenge', 'startChallenge')->name('start_challenge')->middleware('role:Child');
        Route::post('/{id}/document-challenge', 'documentChallenge')->name('document_challenge')->middleware('role:Child');
    });

    Route::group([
        'controller' => SessionController::class,
        'prefix' => '/sessions',
    ], function () {

        Route::get('/all', 'index')->name('sessions_index');
        Route::get('/for-current-program', 'getCurrentProgramSessions')->name('sessions_current_program');
        Route::get('/for-child', 'getSessionsForChild')->middleware('role:Child')->name('child_sessions');
        Route::get('/', 'show')->name('sessions_show');      //*pass id using query params
        Route::post('/{id}/child-start-session', 'childStartSession')->middleware('role:Child')->name('child_start_session');

        //*For Child  Rates
        Route::group(['prefix' => '/{sessionId}/rates', 'controller' => SessionRateController::class], function () {
            Route::post('/', 'store')->middleware('role:Child')->name('session_rates_store');
            Route::get('/', 'index')->name('session_rates_index');
            Route::put('/{id}', 'update')->name('session_rates_update');
            Route::get('/', 'show')->name('session_rates_show');      //*pass id using query params
            Route::delete('/{id}', 'destroy')->name('session_rates_delete');
        });


        //*For Facilitator
        Route::middleware('role:Facilitator')->group(function () {
            Route::post('/close-session/{id}', 'closeSession')->name('close_session');
        });

        //*For Manager and admin
        Route::group(['middleware' => 'role:Admin|Manager'], function () {
            Route::post('/', 'store')->name('sessions_store');
            Route::post('/{id}', 'update')->name('sessions_update');
            Route::delete('/{id}', 'destroy')->name('sessions_delete');
        });
    });

    Route::group([
        'controller' => QuestionController::class,
    ], function () {
        Route::prefix('/sessions/{sessionId}/questions')->group(function () {
            Route::get('/all', 'index')->name('questions_index');
            Route::post('/', 'store')->name('questions_store');
        });

        Route::prefix('/questions')->group(function () {
            Route::get('/', 'show')->name('questions_show');      //*pass id using query params
            Route::post('/{id}', 'update')->middleware('role:Admin|Manager')->name('questions_update');
            Route::post('/{id}/answer-on-question', 'childAnswerOnQuestion')->middleware('role:Child')->name('child_answer_on_question');
            Route::delete('/{id}', 'destroy')->middleware('role:Admin|Manager')->name('questions_delete');
        });
    });


    Route::group([
        'controller' => SuggestedAnswerController::class
    ], function () {
        Route::get('/questions/{questionId}/suggested-answers/all', 'index')->name('suggested_answers_index');
        Route::post('/questions/{questionId}/suggested-answers/', 'store')->middleware('role:Admin|Manager')->name('suggested_answers_store');
        Route::post('/suggested-answers/{id}', 'update')->middleware('role:Admin|Manager')->name('suggested_answers_update');
        Route::delete('/suggested-answers/{id}', 'destroy')->middleware('role:Admin|Manager')->name('suggested_answers_delete');
    });


    Route::group([
        'controller' => ConceptController::class
    ], function () {
        Route::prefix('/sessions/{sessionId}/concepts')->group(function () {
            Route::get('/all', 'index')->name('concepts_index');
            Route::post('/', 'store')->middleware('role:Admin|Manager')->name('concepts_store');
        });

        Route::prefix('/concepts')->group(function () {
            Route::get('/', 'show')->name('concepts_show');      //*pass id using query params
            Route::post('/{id}', 'update')->middleware('role:Admin|Manager')->name('concepts_update');
            Route::delete('/{id}', 'destroy')->middleware('role:Admin|Manager')->name('concepts_delete');
        });
    });

    //********************************************************* */
    //********************************************************* */
    //********************************************************* */
    //********************************************************* */
    //********************************************************* */
    //********************************************************* */
    //********************************************************* */



    Route::group([
        'controller' => AnswerController::class
    ], function () {
        // Route::get('/children/{childId}/answers/all', 'index')->name('child_questions_index');
        // Route::get('/', 'show')->name('child_questions_show');      //*pass id using query params

        Route::post('/questions/{questionId}/child-answer', 'answerQuestion')->middleware('role:Child')->name('child_answer_question');
        Route::get('/questions/{questionId}/children/{childId}', 'getChildAnswer');
        // Route::post('/', 'store')->name('child_questions_store');
        // Route::post('/{id}', 'update')->name('child_questions_update');
        // Route::delete('/{id}', 'destroy')->name('child_questions_delete');
    });




    Route::group([
        'prefix' => '/session-checklist',
        'controller' => SessionChecklistController::class
    ], function () {
        Route::post('/check-children', 'store')->middleware('role:Facilitator')->name('session_checklist_store');
        // Route::get('/all', 'index')->name('session_checklist_index');
        // Route::post('/{id}', 'update')->name('session_checklist_update');
        // Route::get('/', 'show')->name('session_checklist_show');      //*pass id using query params
        // Route::delete('/{id}', 'destroy')->name('session_checklist_delete');
    });


    Route::group(['prefix' => '/trips', 'controller' => TripController::class], function () {
        Route::post('/', 'store')->name('trips_store');
        Route::get('/all', 'index')->name('trips_index');
        Route::post('/{id}', 'update')->name('trips_update');
        Route::get('/', 'show')->name('trips_show');      //*pass id using query params
        Route::delete('/{id}', 'destroy')->name('trips_delete');
    });

    Route::group(['prefix' => '/surveys', 'controller' => SurveyController::class], function () {
        Route::get('/all', 'index')->name('surveys_index');
        Route::get('/', 'show')->name('surveys_show');      //*pass id using query params
        Route::post('/', 'store')->middleware('role:Admin|Manager')->name('surveys_store');
        Route::post('/{id}', 'update')->middleware('role:Admin|Manager')->name('surveys_update');
        Route::delete('/{id}', 'destroy')->middleware('role:Admin|Manager')->name('surveys_delete');
    });
});



//********************************************************************************* */
//********************************************************************************* */
//********************************************************************************* */

//*Guest Routes

Route::group(['prefix' => '/auth', 'controller' => AuthController::class], function () {
    //*login for users
    Route::post('/user-login', 'userLogin')->name('user_login');

    //*login for children
    Route::post('/child-login', 'childLogin')->name('child_login');
});


//********************************************************************************* */
//********************************************************************************* */
//********************************************************************************* */


Route::group(['prefix' => '/positions', 'controller' => PositionController::class], function () {
    Route::post('/', 'store')->name('positions_store');
    Route::get('/all', 'index')->name('positions_index');
    Route::post('/{id}', 'update')->name('positions_update');
    Route::get('/', 'show')->name('positions_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('positions_delete');
});







Route::group(['prefix' => '/position-trips', 'controller' => PositionTripController::class], function () {
    Route::post('/', 'store')->name('position_trips_store');
    Route::get('/all', 'index')->name('position_trips_index');
    Route::post('/{id}', 'update')->name('position_trips_update');
    Route::get('/', 'show')->name('position_trips_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('position_trips_delete');
});

Route::group(['prefix' => '/facilitator-trips', 'controller' => FacilitatorTripController::class], function () {
    Route::post('/', 'store')->name('facilitator_trips_store');
    Route::get('/all', 'index')->name('facilitator_trips_index');
    Route::post('/{id}', 'update')->name('facilitator_trips_update');
    Route::get('/', 'show')->name('facilitator_trips_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('facilitator_trips_delete');
});

Route::group(['prefix' => '/child-trip-checklists', 'controller' => ChildTripChecklistController::class], function () {
    Route::post('/', 'store')->name('child_trip_checklists_store');
    Route::get('/all', 'index')->name('child_trip_checklists_index');
    Route::post('/{id}', 'update')->name('child_trip_checklists_update');
    Route::get('/', 'show')->name('child_trip_checklists_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('child_trip_checklists_delete');
});

Route::group(['prefix' => '/items', 'controller' => ItemController::class], function () {
    Route::post('/', 'store')->name('items_store');
    Route::get('/all', 'index')->name('items_index');
    Route::post('/{id}', 'update')->name('items_update');
    Route::get('/', 'show')->name('items_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('items_delete');
});

Route::group(['prefix' => '/item-requests', 'controller' => ItemRequestController::class], function () {
    Route::post('/', 'store')->name('item_requests_store');
    Route::get('/all', 'index')->name('item_requests_index');
    Route::post('/{id}', 'update')->name('item_requests_update');
    Route::get('/', 'show')->name('item_requests_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('item_requests_delete');
});



Route::group(['prefix' => '/challenge-children', 'controller' => ChallengeChildController::class], function () {
    Route::post('/', 'store')->name('challenge_children_store');
    Route::get('/all', 'index')->name('challenge_children_index');
    Route::post('/{id}', 'update')->name('challenge_children_update');
    Route::get('/', 'show')->name('challenge_children_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('challenge_children_delete');
});



Route::group(['prefix' => '/survey-users', 'controller' => SurveyUserController::class], function () {
    Route::post('/', 'store')->name('survey_users_store');
    Route::get('/all', 'index')->name('survey_users_index');
    Route::post('/{id}', 'update')->name('survey_users_update');
    Route::get('/', 'show')->name('survey_users_show');      //*pass id using query params
    Route::delete('/{id}', 'destroy')->name('survey_users_delete');
});





/**
Route::get('/test', function () {


    // $transactions = [
    //     ['bread', 'milk'],
    //     ['bread', 'diaper', 'beer', 'eggs'],
    //     ['milk', 'diaper', 'beer', 'coke'],
    //     ['bread', 'milk', 'diaper', 'beer'],
    //     ['bread', 'milk', 'diaper', 'coke']
    // ];
    $aprioriConfiguration = new \CodedHeartInside\DataMining\Apriori\Configuration();

    // Configuring the boundries is optional
    $aprioriConfiguration->setDisplayDebugInformation();
    $aprioriConfiguration->setMinimumThreshold(2) // Default is 2
        ->setMinimumSupport(0.2) // Default is 0.1
        ->setMinimumConfidence(5) // Default is 0.2
    ;
    $dataSet = array(
        array(1, 3, 4),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4, 6),
        array(2, 4),
        array(2, 4),
        array(2, 4),
        array(2, 4),
        array(1, 2),
        array(5),
    );



    $dataInput = new \CodedHeartInside\DataMining\Apriori\Data\Input($aprioriConfiguration);
    $dataInput->flushDataSet()
        ->addDataSet($dataSet);
        // ->addDataSet($dataSet) // In this case, the data set is added twice to create more testing data
    ;

    $aprioriClass = new \CodedHeartInside\DataMining\Apriori\Apriori($aprioriConfiguration);
    $aprioriClass->run();

    // foreach ($aprioriClass->getSupportRecords() as $record) {
    //     print_r($record);
    // }


    // foreach ($aprioriClass->getConfidenceRecords() as $record) {
    //     print_r($record);
    //     // Outputs
    //     // Array
    //     // (
    //     //     [if] => Array
    //     //     (
    //     //       [0] => 1
    //     //       [1] => 7
    //     //     )
    //     //
    //     //     [then] => 3
    //     //     [confidence] => 1
    //     // )
    // }
    $frequentItemsets = $aprioriClass->generateFrequentItemsets();
    $associationRules = $aprioriClass->generateAssociationRules($frequentItemsets, 5);

});
 */
