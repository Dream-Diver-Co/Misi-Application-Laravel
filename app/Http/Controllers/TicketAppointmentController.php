<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Models\LeaveSchedule;
use App\Models\Therapist;
use App\Models\Ticket;
use App\Models\TicketAppointment;
use App\Models\WorkDayTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Mail\CancelMail;
use Illuminate\Support\Facades\Mail;

class TicketAppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:patient|admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = TicketAppointment::all();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Ticket',
            'Status',
            'Remarks',
            'Fee',
            'Created At',
            'Updated At',
        ];



        $data = [];

        foreach ($appointments as $appointment) {

            $items = [];

            array_push($items, '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('ticket-appointments.destroy', ['ticket_appointment' => $appointment->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('ticket-appointments.show', ['ticket_appointment' => $appointment->id]) . '"  data-toggle="tooltip" data-placement="top" title="Show Appointment Information">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a><button class="btn btn-xs btn-default text-primary mx-1 shadow createModal" data-toggle="tooltip" data-placement="top" title="Create Intake" data-appointment="' . $appointment->id . '" data-ticket-id="' . $appointment->ticket_id . '">
                    <i class="fa fa-lg fa-fw fa-plus"></i>
                </button></nobr>', '</a><a class="text-info mx-1" href="' . route('ticket-appointments.show', ['ticket_appointment' => $appointment->id]) . '">
                    ' .   $appointment->id . '</a>', $appointment->ticket()->first()->id, ucfirst($appointment->status), $appointment->remarks, $appointment->fee, Carbon::parse($appointment->created_at)->format('d F, Y'), Carbon::parse($appointment->updated_at)->format('d F, Y'),);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('ticketAppointment.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $tickets = Ticket::where('department_id', 11)->get();
        $tickets = Ticket::where('department_id', 10)->get();
        return view('ticketAppointment.create', compact('tickets'));
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

        $ticket = Ticket::where('id', $data['select-ticket'])->first();
        //dd($ticket->suggested_therapists);
        $assigned_therapists = $ticket->assigned_therapist;
        $assigned_therapists ? $assigned_therapists : null;

        try {

            $data_startTime = $data['appointment-time'];
            $startTime = Carbon::parse($data_startTime);
            $endTime = $startTime->copy()->addMinutes(60);

            $appointment = new TicketAppointment();

            $appointment->ticket_id = $data['select-ticket'];
            $appointment->fee = $data['appointment-fee'];

            $appointment->time = $data['appointment-time'];
            $appointment->date = $data['appointment-date'];


            $appointment->status = $data['select-status'];
            $appointment->type = $data['appointment-type'];

            $appointment->assigned_therapists = $assigned_therapists;
            $appointment->therapist_comment = $data['therapist-comment'];
            $appointment->remarks = $data['remarks'];

            $appointment->save();

            $intake = new Intake();

            $intake->appointment_id = $appointment->id;
            $intake->date = $data['appointment-date'];
            $intake->start_time = $startTime->format('H:i:s');
            $intake->end_time = $endTime->format('H:i:s');
            $intake->status = 'not_visited';
            $intake->payment_method = 'N/A';
            $intake->payment_status = 'Unpaid';

            $intake->save();




            // mail send start


            //data collect
            $therapist_id = $ticket->assigned_therapist;
            $therapist = Therapist::where('id', $therapist_id)->first();


            $therapist_name = $therapist->user->name;
            $patient_name = $ticket->patient->user->name;
            $appointment_date = $data['appointment-date'];
            $appointment_time = $startTime->format('H:i:s');


            // send

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
        $appointment = TicketAppointment::where('id', $id)->first();

        // intake part
        $intakes = Intake::where('appointment_id', $appointment->id)->get();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'INVOICE',
            'ID',
            'Date',
            'Time',
            'Status',
            'Payment Method',
            'Payment Status',
            'Created At',
            'Updated At'
        ];



        $data = [];

        foreach ($intakes as $intake) {
            $download_button  = '<span class="d-inline-block badge badge-success badge-pill badge-lg owned" style="cursor: pointer">Download</span>';
            $items = [];

            array_push(
                $items,
                '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('ticket-appointments.destroy', ['ticket_appointment' => $appointment->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><button class="btn btn-xs btn-default text-teal mx-1 shadow showModal" data-intake-id="' . $intake->id . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </button></nobr>',
                '</a><a class="text-info mx-1" href="' . route('generate-invoice', ['id' => $intake->id])  . '">
                ' .   $download_button . '</a>',

                $intake->id,
                Carbon::parse($intake->date)->format('d F, Y'),
                $intake->start_time,
                ucfirst($intake->status),
                ucfirst($intake->payment_method),
                ucfirst($intake->payment_status),
                Carbon::parse($intake->created_at)->format('d F, Y'),
                Carbon::parse($intake->updated_at)->format('d F, Y'),
            );
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];
        // end intake part
        return view('ticketAppointment.show', compact('appointment', 'heads', 'config'));
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
        // dd($data);


        try {


            $appointment = TicketAppointment::where('id', $id)->first();


            $appointment->ticket_id = $data['select-ticket'];
            $appointment->fee = $data['appointment-fee'];
            $appointment->status = $data['select-status'];
            $appointment->type = $data['appointment-type'];

            $appointment->therapist_comment = $data['therapist-comment'];
            $appointment->remarks = $data['remarks'];

            //$appointment->save();

            if ($data['select-status'] == 'cancelled') {

                //$appointment_time_from_intake = $appointment->intakes->all();

                // if (!empty($appointment_time_from_intake)) {
                //     $lastItem = end($appointment_time_from_intake);
                //     $appontment_date_last_intake = $lastItem->date;
                //     $appontment_time_last_intake = $lastItem->start_time;
                // }


                //mail send


                $ticket_id = $data['select-ticket'];
                $ticket = Ticket::where('id', $ticket_id)->first();

                //data collect
                // $therapist_id = $ticket->assigned_therapist;
                // $therapist = Therapist::where('id', $therapist_id)->first();



                $patient_name = $ticket->patient->user->name;

                // $therapist_name = $therapist->user->name;
                // $appointment_date = $appontment_date_last_intake;
                // $appointment_time = $appontment_time_last_intake;

                $emailTemplate = EmailTemplate::where('id', 2)->first();
                $userEmail = $ticket->patient()->first()->user()->first()->email;

                $subject = $emailTemplate->mail_subject;
                $body = $emailTemplate->mail_body;

                $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;



                // $body = ($appointment_date !== null) ? str_replace("#appointmentDate", $appointment_date, $body) : $body;
                // $body = ($appointment_time !== null) ? str_replace("#appointmentTime", $appointment_time, $body) : $body;
                // $body = ($therapist_name !== null) ? str_replace("#therapistName", $therapist_name, $body) : $body;
                //dd($body);

                $recipientName = $ticket->patient()->first()->user()->first()->name;

                $mail = new CancelMail();
                $mail->subject = $subject;
                $mail->body = $body;
                $mail->recipientName = $recipientName;

                Mail::to($userEmail)->send($mail);
            }

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

    public function getDatesAndAppoints($id)
    {
        $therapistId = Ticket::where('id', $id)->first()->assigned_therapist;
        $leaves_data = LeaveSchedule::where('therapist_id', $therapistId)->get();

        $holidays = WorkDayTime::where('therapist_id', $therapistId)->first()->weekly_holidays;
        $start_time = WorkDayTime::where('therapist_id', $therapistId)->first()->start_time;
        $end_time = WorkDayTime::where('therapist_id', $therapistId)->first()->end_time;

        // Convert the dates from JSON string to an array
        $leaves = $leaves_data->map(function ($leave) {
            $leave->dates = json_decode($leave->dates);
            return $leave;
        });

        $dates = $leaves->pluck('dates')->flatten()->toArray();



        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(14);

        $appointment_of_therapist_one = TicketAppointment::where('assigned_therapists', $therapistId)
                ->whereDate('date', '>=', $startDate) // Filter for appointments starting from today
                ->whereDate('date', '<=', $endDate) // Filter for appointments up to the next 14 days
                ->orderBy('date') // Ensure appointments are sorted by date
                ->get()
                ->groupBy(function($appointment) {
                    // Note: Changed the variable to $appointment for clarity, as it represents the appointment model, not just a date.
                    return \Carbon\Carbon::parse($appointment->date)->format('Y-m-d'); // Group by date only, ignoring time if present
                });



        return response()->json([ 'therapistId' =>$therapistId ,'leave_dates' => $dates, 'holidays' => $holidays, 'start_time' => $start_time , 'end_time' => $end_time, 'appointment_of_therapist_one' => $appointment_of_therapist_one]);
    }

    public function getIntake($id)
    {

        $intake = Intake::where('id', $id)->first();

        return response()->json($intake);
    }

    public function toCalendar()
    {
        $therapists = Therapist::all();
        return view('ticketAppointment.calendar', compact('therapists'));
    }

    public function getEvents()
    {
        $intakes = Intake::all();

        $formattedEvents = [];

        foreach ($intakes as $event) {
            $formattedEvents[] = [
                'title' => 'Appointment for ticket - ' . $event->appointment()->first()->ticket()->first()->id,
                'start' => $event->date . 'T' . $event->start_time,
                'end' => $event->date . 'T' . $event->end_time,
                'extendedProps' => [
                    'therapistId' => $event->appointment()->first()->ticket()->first()->assigned_therapist,
                ],

            ];
        }

        return response()->json($formattedEvents);
    }
}
