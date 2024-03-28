<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\TicketAppointment;
use App\Models\Intake;
use App\Models\Ticket;
use App\Models\Patient;
use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\Therapist;

class GenerateInvoiceController extends Controller
{


    public function generatePDF(Request $request, $id)
    {


        $intake = Intake::where('id', $id)->first();
        // dd($intake);
        $appointment = TicketAppointment::where('id', $intake->appointment_id)->first();
        //dd($appointment);
        $ticket = Ticket::where('id', $appointment->ticket_id)->first();
        //dd($ticket);
        $patient = Patient::where('id', $ticket->patient_id)->first();
        //dd($patient);
        $user = User::where('id', $patient->user_id)->first();
        //dd($user);

        $pdf = PDF::loadView('invoice', compact('intake', 'appointment', 'patient', 'user'));
        //dd($pdf);

        return $pdf->stream();
    }


    public function generatePdfForEmail(Request $request)
    {
        $ticketId = $request->input('ticketId');
        $mailId = $request->input('mailId');
        $ticket = Ticket::where('id', $ticketId)->first();

        // new added

        $therapist_id = $ticket->assigned_therapist;
        if ($therapist_id != null) {
            $therapist = Therapist::where('id', $therapist_id)->first();
            $therapist_name = $therapist->user->name;
        }

        $patient_name = $ticket->patient->user->name;
        // $appointment_date = $data['appointment-date'];
        // $appointment_time = $startTime->format('H:i:s');


        //$emailTemplate = EmailTemplate::where('id', 1)->first();
        $emailTemplate = EmailTemplate::where('id', $request->input('mailId'))->first();
        //$userEmail = $ticket->patient()->first()->user()->first()->email;
        $subject = $emailTemplate->mail_subject;
        $body = $emailTemplate->mail_body;


        // $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;
        // $body = ($appointment_date !== null) ? str_replace("#appointmentDate", $appointment_date, $body) : $body;
        // $body = ($appointment_time !== null) ? str_replace("#appointmentTime", $appointment_time, $body) : $body;
        // $body = ($therapist_name !== null) ? str_replace("#therapistName", $therapist_name, $body) : $body;

        //end



        if ($request->input('mailId') != null) {
            //$emailTemplate = EmailTemplate::where('id', $request->input('mailId'))->first();
            $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;
        }
        $pdf = PDF::loadView('emailPdf', compact('ticket', 'subject', 'body'));
        return $pdf->stream();
    }
}
