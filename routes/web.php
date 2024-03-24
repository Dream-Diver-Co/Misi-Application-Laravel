<?php

use App\Http\Controllers\Appointment;
use App\Http\Controllers\EmailTamplateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HeranmeldingController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\NoApprovalController;
use App\Http\Controllers\PibController;
use App\Http\Controllers\PitController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TicketAppointmentController;
use App\Http\Controllers\VtcbController;
use App\Http\Controllers\WorkSchedule;
use App\Http\Controllers\YesApprovalController;

use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class); // only admin cas access
    Route::resource('therapists', TherapistController::class); // therapist & admin cas access
    Route::resource('tickets', TicketController::class);
    Route::resource('screening', ScreeningController::class); // screener & admin cas access
    Route::resource('pib', PibController::class);
    Route::resource('pit', PitController::class);
    Route::resource('heranmelding', HeranmeldingController::class);
    Route::resource('yes-approvals', YesApprovalController::class);
    Route::resource('appointment-groups', Appointment::class);
    Route::resource('no-approvals', NoApprovalController::class);
    Route::resource('vtcbs', VtcbController::class);
    Route::resource('ticket-appointments', TicketAppointmentController::class);
    Route::resource('appointment-intake', IntakeController::class);
    Route::post('/delet-attachment', [AttachmentController::class, 'destroy'])->name('attachment');

    // Route for ticket update
    Route::post('/therapist-update/{id}', [TherapistController::class, 'update'])->name('therapists-update');
    Route::post('/patient-update/{id}', [PatientController::class, 'update'])->name('patients-update');

    Route::post('/update-ticket/{id}', [TicketController::class, 'update'])->name('update-ticket');
    Route::post('/update-screener-ticket/{id}', [ScreeningController::class, 'update'])->name('update-screener-ticket');
    Route::post('/update-pib-ticket/{id}', [PibController::class, 'update'])->name('update-pib-ticket');
    Route::post('/update-pit-ticket/{id}', [PitController::class, 'update'])->name('update-pit-ticket');
    Route::post('/update-yes-approval-ticket/{id}', [YesApprovalController::class, 'update'])->name('update-yes-approval-ticket');
    Route::post('/update-no-approval-ticket/{id}', [NoApprovalController::class, 'update'])->name('update-no-approval-ticket');
    Route::post('/update-heranmelding-ticket/{id}', [HeranmeldingController::class, 'update'])->name('update-heranmelding-ticket');
    Route::post('/update-vtcb-ticket/{id}', [VtcbController::class, 'update'])->name('update-vtcb-ticket');
    Route::post('/update-appointment-group-ticket/{id}', [Appointment::class, 'update'])->name('update-appointment-group-ticket');


    Route::resource('questions', QuestionController::class);
    Route::resource('work-schedules', WorkSchedule::class);
    //Route::get('/user/{id}', [WorkSchedule::class, 'index']);
    Route::get('/get-intake/{id}', 'App\Http\Controllers\TicketAppointmentController@getIntake');
    Route::get('/appointments-calendar', 'App\Http\Controllers\TicketAppointmentController@toCalendar');
    Route::get('/calendar-events', 'App\Http\Controllers\TicketAppointmentController@getEvents');

    Route::get('/datesandappoints/{id}', 'App\Http\Controllers\TicketAppointmentController@getDatesAndAppoints');
    Route::get('/compareAppointment/{id}', 'App\Http\Controllers\TicketAppointmentController@getCompareAppointment');

    Route::get('/missing-info-tickets', 'App\Http\Controllers\TicketController@missingInfo');
    Route::get('/update-assigned-to', 'App\Http\Controllers\TicketController@updateAssignedTo');
    Route::get('/get-role-users', 'App\Http\Controllers\TicketController@getUsersByRole');

    Route::get('/cancel-ticket', 'App\Http\Controllers\TicketController@cancelTicket')->name('cancel-ticket');

    Route::get('/email-send-for-cancel', 'App\Http\Controllers\TicketController@sendEmailForCancel')->name('email-send-for-cancel');

    Route::get('/cancelled-tickets', 'App\Http\Controllers\TicketController@getCancelledTickets')->name('cancelled-tickets');
    Route::get('/get-histories', 'App\Http\Controllers\TicketController@getHistories')->name('ticket-history');
    Route::get('/to-formula', 'App\Http\Controllers\QuestionController@toFormula')->name('get-form-data');
    Route::get('/update-answers', 'App\Http\Controllers\QuestionController@updateAnswers')->name('update-answer');
    Route::get('/to-fetch-worktime', 'App\Http\Controllers\WorkSchedule@toFetchData')->name('fetch-worktime');
    Route::get('/leaves', 'App\Http\Controllers\WorkSchedule@leaveIndex')->name('leaves');
    Route::POST('/create-leaves', 'App\Http\Controllers\WorkSchedule@leaveCreate')->name('create-leaves');
    Route::get('/to-fetch-leaves', 'App\Http\Controllers\WorkSchedule@toFetchLeaves')->name('fetch-leaves');
    Route::get('/update-leaves/{id}', 'App\Http\Controllers\WorkSchedule@UpdateLeaves')->name('update-leaves');
    Route::get('/update-worktime/{id}', 'App\Http\Controllers\WorkSchedule@updateWorkTime')->name('update-worktime');
    Route::get('/getemailsforcancel', 'App\Http\Controllers\EmailTamplateController@getEmailForCancel')->name('get-cancel-email');

    Route::get('/getemailsforsend', 'App\Http\Controllers\EmailTamplateController@getEmailForSend')->name('get-send-email');

    Route::resource('email-templates', EmailTamplateController::class);

    Route::get('/generate-invoice/{id}', 'App\Http\Controllers\GenerateInvoiceController@generatePDF')->name('generate-invoice');

    Route::get('/ticket-create-from-referral', 'App\Http\Controllers\TicketController@getReferral')->name('ticket-create-from-referral');
    Route::post('/create-ticket-from-referral', [TicketController::class, 'createTicketFromReferral'])->name('ticket-referral');

    Route::post('/patient-update-from-ticket/{id}', [PatientController::class, 'update_from_ticket'])->name('update-from-ticket');

    Route::get('/generate-email-pdf', 'App\Http\Controllers\GenerateInvoiceController@generatePdfForEmail')->name('generate-email-pdf');

    Route::get('/search', 'App\Http\Controllers\SearchController@searchById')->name('searchById');
});
