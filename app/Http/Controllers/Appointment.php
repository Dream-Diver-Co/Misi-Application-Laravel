<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Patient;
use App\Models\Therapist;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Attachment;
use App\Models\TicketAppointment;
use App\Models\Intake;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;
//use Carbon\Carbon;

class Appointment extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:appointment|admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointmentRoleId = Role::where('name', 'appointment')->first()->id;
        $tickets = Ticket::where('department_id', $appointmentRoleId)->get();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Assigned To',
            'Patient ID',
            'Department',
            'Status',
            'Mono/Multi ZD',
            'Mono/Multi Screening',
            'Intake or Therapist',
            'Tresonit Number',
            'Datum Intake',
            'Datum Intake 2',
            'ND Account',
            'AVC/ALFMVM/SBG',
            'Honos',
            'Berha Intake',
            'ROM Start',
            'ROM End',
            'Berha End',
            'VTCB Date',
            'Closure',
            'Aanm Intake',
            'Location',
            'Strike',
            'Remarks',
        ];



        $data = [];

        foreach ($tickets as $ticket) {
            if ($ticket->assigned_staff === null) {
                $assigned = '<span class="d-inline-block badge badge-warning badge-pill badge-lg assign-me" data-row-id="' . $ticket->id . '" style="cursor: pointer">Assign to Me</span>';
            } elseif ($ticket->assigned_staff == Auth::user()->id) {
                $assigned = '<span class="d-inline-block badge badge-success badge-pill badge-lg owned" style="cursor: pointer">Owned</span>';
            } else {
                $assigned = $ticket->assigned_staff;
            }
            $items = [];

            array_push(
                $items,
                '<nobr><a class="btn btn-xs btn-default text-primary mx-1 shadow" href="' . route('appointment-groups.edit', ['appointment_group' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>



                    <a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('appointment-groups.show', ['appointment_group' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a>
                    <button class="btn btn-xs btn-default text-grey mx-1 shadow pib-form-open" data-toggle="tooltip" data-placement="top" title="Open PiT form" data-ticket-id="' . $ticket->id . '" data-form-type="' . 1 . '">
                    <i class="fa fa-lg fa-fw fa-pager"></i>
                    </button>

                    <button class="btn btn-xs btn-default text-grey mx-1 shadow pit-form-open" data-toggle="tooltip" data-placement="top" title="Open PiT form" data-ticket-id="' . $ticket->id . '" data-form-type="' . 2 . '">
                        <i class="fas fa-laptop-medical"></i>
                    </button>


                    </nobr>',

                '</a><a class="text-info mx-1" href="' . route('appointment-groups.show', ['appointment_group' => $ticket->id]) . '">
                    ' . $ticket->id . '</a>',

                // $ticket->id,
                $assigned,
                $ticket->patient()->first()->id,
                $ticket->department_id != null ?  ucfirst(Role::where('id', $ticket->department_id)->first()->name) : '',
                ucfirst($ticket->status),

                $ticket->mono_multi_zd,
                $ticket->mono_multi_screening,
                $ticket->intake_or_therapist,
                $ticket->tresonit_number,
                $ticket->datum_intake,
                $ticket->datum_intake_2,
                $ticket->nd_account,
                $ticket->avc_alfmvm_sbg,
                $ticket->honos,
                $ticket->berha_intake,
                $ticket->rom_start,
                $ticket->rom_end,
                $ticket->berha_end,
                $ticket->vtcb_date,
                $ticket->closure,
                $ticket->aanm_intake_1,
                $ticket->location,
                $ticket->call_strike,
                $ticket->remarks
            );
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('appointment.index', compact('heads', 'config'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = ['screener', 'pib', 'pit', 'heranmelding', 'yes approval', 'no approval', 'vtcb',  'appointment'];
        $therapists = Therapist::all();
        //dd($therapists);
        $matchingRoles = Role::whereIn('name', $roles)->get();
        // $screener = Role::where('name', 'screener')->first();
        $patients = Patient::all();
        $ticketId = $id;
        $ticket = Ticket::where('id', $id)->first();
        $patient = $ticket->patient()->first();

        // $therapist = $ticket->therapist()->first();

        // count appointment

        // $therapistId = 3; // The value you want to search for
        // $matchingRows = TicketAppointment::where('assigned_therapists', $therapistId)->pluck('id');
        // $startDate = Carbon::now();
        // $endDate = $startDate->copy()->addDays(14);
        // $totalIntake = DB::table('intakes')
        //     ->whereIn('appointment_id', $matchingRows)
        //     ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
        //     ->count();

        // dd($totalIntake);



        $emailTemplates = EmailTemplate::all();
        $mailTypes = $emailTemplates->pluck('mail_type')->unique()->toArray();
        $attachments = $ticket->attachments;
        $countries = Countries::all();

        $suggested_array = json_decode($ticket->suggested_therapists);
        //dd($suggested_array);

        $assigned_therapist_one_id = $suggested_array[0];
        $therapist_one = Therapist::find($assigned_therapist_one_id);
        $user_with_therapist_one = User::find($therapist_one->user_id);
        //$appointment_of_therapist_one = TicketAppointment::where('assigned_therapists',$assigned_therapist_one_id)->get();

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(14);

        $appointment_of_therapist_one = TicketAppointment::where('assigned_therapists', $assigned_therapist_one_id)
                ->whereDate('date', '>=', $startDate) // Filter for appointments starting from today
                ->whereDate('date', '<=', $endDate) // Filter for appointments up to the next 14 days
                ->orderBy('date') // Ensure appointments are sorted by date
                ->get()
                ->groupBy(function($appointment) {
                    // Note: Changed the variable to $appointment for clarity, as it represents the appointment model, not just a date.
                    return \Carbon\Carbon::parse($appointment->date)->format('Y-m-d'); // Group by date only, ignoring time if present
                });



        $assigned_therapist_two_id = $suggested_array[1];
        $therapist_two = Therapist::find($assigned_therapist_two_id);
        $user_with_therapist_two = User::find($therapist_two->user_id);
        //$appointment_of_therapist_two = TicketAppointment::where('assigned_therapists',$assigned_therapist_two_id)->get();

        $appointment_of_therapist_two = TicketAppointment::where('assigned_therapists', $assigned_therapist_two_id)
                ->whereDate('date', '>=', $startDate) // Filter for appointments starting from today
                ->whereDate('date', '<=', $endDate) // Filter for appointments up to the next 14 days
                ->orderBy('date') // Ensure appointments are sorted by date
                ->get()
                ->groupBy(function($appointment) {
                    // Note: Changed the variable to $appointment for clarity, as it represents the appointment model, not just a date.
                    return \Carbon\Carbon::parse($appointment->date)->format('Y-m-d'); // Group by date only, ignoring time if present
                });



        $assigned_therapist_three_id = $suggested_array[2];
        $therapist_three = Therapist::find($assigned_therapist_three_id);
        $user_with_therapist_three = User::find($therapist_three->user_id);
        //$appointment_of_therapist_three = TicketAppointment::where('assigned_therapists', $assigned_therapist_three_id )->get();
        $appointment_of_therapist_three = TicketAppointment::where('assigned_therapists', $assigned_therapist_three_id)
                ->whereDate('date', '>=', $startDate) // Filter for appointments starting from today
                ->whereDate('date', '<=', $endDate) // Filter for appointments up to the next 14 days
                ->orderBy('date') // Ensure appointments are sorted by date
                ->get()
                ->groupBy(function($appointment) {
                    // Note: Changed the variable to $appointment for clarity, as it represents the appointment model, not just a date.
                    return \Carbon\Carbon::parse($appointment->date)->format('Y-m-d'); // Group by date only, ignoring time if present
                });
        //dd($appointment_of_therapist_three);




        return view('appointment.show', compact('patients', 'matchingRoles', 'ticketId', 'therapists', 'ticket', 'patient', 'mailTypes', 'attachments', 'countries','appointment_of_therapist_one','appointment_of_therapist_two','appointment_of_therapist_three','user_with_therapist_one','user_with_therapist_two','user_with_therapist_three'));
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

        //dd($data);

        try {
            $ticket = Ticket::where('id', $id)->first();

            if ($data['select-status'] == 'onhold' && $data['select-department'] != '') {
                $ticket->status = $data['select-status'];
            }

            if ($data['select-status'] == 'in_progress' && $data['select-department'] != '') {
                $ticket->status = $data['select-status'];
            }

            if ($data['select-status'] == 'open' && $data['select-department'] == '') {
                $ticket->status = $data['select-status'];
            }

            if ($data['select-department'] != $ticket->department_id) {
                $ticket->status = 'open';
            }

            if ($data['assign-to'] == '') {
                $ticket->status = 'open';
            }

            if ($data['assign-to'] != '' && $ticket->assigned_staff != $data['assign-to']) {
                $ticket->status = 'onhold';
            }

            // if ($data['select-department'] != $ticket->department_id && $data['select-status'] == 'work_finished') {
            //     $ticket->status = $data['select-status'];
            // }


            $ticket->department_id = $data['select-department'];

            if ($ticket->department_id != null && $data['assign-to'] != '') {
                $ticket->assigned_staff = $data['assign-to'];
            } else {
                $ticket->assigned_staff = null;
            }
            $ticket->patient_id = $data['select-patient'];
            $ticket->zd_id = $data['zd_id'];
            $ticket->mono_multi_zd = $data['mono-multi-zd'];
            $ticket->mono_multi_screening = $data['mono-multi-screening'];
            $ticket->intake_or_therapist = $data['intakes-therapist'];
            $ticket->tresonit_number = $data['tresonit-number'];
            $ticket->datum_intake = $data['datum-intake'];
            $ticket->datum_intake_2 = $data['datuem-intake-2'];
            $ticket->nd_account = $data['nd_account'];
            $ticket->avc_alfmvm_sbg = $data['avc-alfmvm-sbg'];
            $ticket->honos = $data['honos'];
            $ticket->berha_intake = $data['berha-intake'];
            // $ticket->strike_history = $data['strike-history'];
            // $ticket->ticket_history = $data['ticket-history'];
            // $ticket->rom_start =  Carbon::createFromFormat('d/m/Y', $data['rom-start'])->format('Y-m-d');
            // $ticket->rom_end = Carbon::createFromFormat('d/m/Y', $data['rom-end'])->format('Y-m-d');
            // $ticket->berha_end = Carbon::createFromFormat('d/m/Y', $data['berha-eind'])->format('Y-m-d');
            // $ticket->vtcb_date = Carbon::createFromFormat('d/m/Y', $data['vtcb-date'])->format('Y-m-d');
            // $ticket->closure = Carbon::createFromFormat('d/m/Y', $data['closure'])->format('Y-m-d');
            // $ticket->aanm_intake_1 = Carbon::createFromFormat('d/m/Y', $data['aanm-intake'])->format('Y-m-d');
            $ticket->rom_start =  $data['rom-start'];
            $ticket->rom_end = $data['rom-end'];
            $ticket->berha_end = $data['berha-eind'];
            $ticket->vtcb_date = $data['vtcb-date'];
            $ticket->closure = $data['closure'];
            $ticket->aanm_intake_1 = $data['aanm-intake'];
            $ticket->location = $data['location'];
            $ticket->call_strike = $data['call-strike'];
            $ticket->remarks = $data['remarks'];
            $ticket->comment = $data['comments'];

            if (array_key_exists('suggest-therapists', $data)) {
                $suggestedTherapists = $data['suggest-therapists'];
                $ticket->suggested_therapists = $suggestedTherapists;
            }

            $ticket->assigned_therapist = $data['assign-therapist'];
            $ticket->language = $data['language-treatment'];
            // $ticket->files = $data[''];

            $ticket->save();
            if ($data['comments'] != null) {
                $history = new TicketHistory();

                $history->ticket_id = $id;
                $history->comment = $data['comments'];

                $history->save();
            }

            // $ticket->save();


            //attachment update

            $files = $request->file('files');

            if ($files) {
                foreach ($files as $file) {

                    $name = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = pathinfo($name, PATHINFO_FILENAME) . time() . '.' . $extension;

                    $attachment = new Attachment();
                    $attachment->ticket_id = $ticket->id;
                    $attachment->attatchment = $file->storeAs('attachments_folder', $filename);
                    $attachment->save();
                }
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
}
