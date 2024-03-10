<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Models\TicketAppointment;
use App\Models\Ticket;
use App\Models\Therapist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Mail\CancelMail;
use Illuminate\Support\Facades\Mail;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        try {
            $startTime = Carbon::parse($data['time']);
            $endTime = $startTime->copy()->addMinutes(60);

            $intake = new Intake();

            $intake->appointment_id = $data['appointment'];
            $intake->date = $data['date'];
            $intake->start_time = $startTime->format('H:i:s');
            $intake->end_time = $endTime->format('H:i:s');
            $intake->status = $data['status'];
            $intake->payment_status = $data['payment_status'];
            $intake->payment_method = $data['payment_method'];

            $intake->save();


            //mail send

            $appoinment_id = $data['appointment'];
            $ticket_appointment = TicketAppointment::find($appoinment_id);
            $ticket_id = $ticket_appointment->ticket_id;
            $ticket = Ticket::where('id', $ticket_id)->first();

            //data collect for template

            $therapist_id = $ticket->assigned_therapist;
            $therapist = Therapist::where('id', $therapist_id)->first();


            $therapist_name = $therapist->user->name;
            $patient_name = $ticket->patient->user->name;
            $appointment_date = $data['date'];
            $appointment_time = $startTime->format('H:i:s');



            $emailTemplate = EmailTemplate::where('id', 1)->first();
            $userEmail = $ticket->patient()->first()->user()->first()->email;

            $subject = $emailTemplate->mail_subject;
            $body = $emailTemplate->mail_body;

            $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;
            $body = ($appointment_date !== null) ? str_replace("#appointmentDate", $appointment_date, $body) : $body;
            $body = ($appointment_time !== null) ? str_replace("#appointmentTime", $appointment_time, $body) : $body;
            $body = ($therapist_name !== null) ? str_replace("#therapistName", $therapist_name, $body) : $body;

            //dd($body);

            $recipientName = $ticket->patient()->first()->user()->first()->name;

            $mail = new CancelMail();
            $mail->subject = $subject;
            $mail->body = $body;
            $mail->recipientName = $recipientName;

            Mail::to($userEmail)->send($mail);


            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $startTime = Carbon::parse($data['time']);
            $endTime = $startTime->copy()->addMinutes(60);

            $intake = Intake::where('id', $id)->first();

            $appoinment_id_from_intake = $intake->appointment_id;

            $intake->date = $data['date'];
            $intake->start_time = $startTime->format('H:i:s');
            $intake->end_time = $endTime->format('H:i:s');
            $intake->status = $data['status'];
            $intake->payment_status = $data['payment_status'];
            $intake->payment_method = $data['payment_method'];

            //$intake->save();

            // mail send

            $appoinment_id = $appoinment_id_from_intake;
            $ticket_appointment = TicketAppointment::find($appoinment_id);
            $ticket_id = $ticket_appointment->ticket_id;
            $ticket = Ticket::where('id', $ticket_id)->first();

            //data collect for template

            $therapist_id = $ticket->assigned_therapist;
            $therapist = Therapist::where('id', $therapist_id)->first();


            $therapist_name = $therapist->user->name;
            $patient_name = $ticket->patient->user->name;
            $appointment_date = $data['date'];
            $appointment_time = $startTime->format('H:i:s');



            $emailTemplate = EmailTemplate::where('id', 1)->first();
            $userEmail = $ticket->patient()->first()->user()->first()->email;

            $subject = $emailTemplate->mail_subject;
            $body = $emailTemplate->mail_body;


            $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;
            $body = ($appointment_date !== null) ? str_replace("#appointmentDate", $appointment_date, $body) : $body;
            $body = ($appointment_time !== null) ? str_replace("#appointmentTime", $appointment_time, $body) : $body;
            $body = ($therapist_name !== null) ? str_replace("#therapistName", $therapist_name, $body) : $body;

            //dd($body);
            $recipientName = $ticket->patient()->first()->user()->first()->name;

            $mail = new CancelMail();
            $mail->subject = $subject;
            $mail->body = $body;
            $mail->recipientName = $recipientName;

            //Mail::to($userEmail)->send($mail);

            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
