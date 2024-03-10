<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Patient;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;
use App\Models\Attachment;
use App\Mail\CancelMail;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Print_;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Countries\Package\Countries;


class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        //dd($tickets);
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Patient ID',
            'Department',
            'Status',
            'Remarks',
            'Created At',
            'Updated At',
            'Strike',
            'Mono/Multi ZD',
            'Mono/Multi Screening',
            'Intake or Therapist',
            // ['label' => 'Phone', 'width' => 40],
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




        ];



        $data = [];

        foreach ($tickets as $ticket) {
            $items = [];

            array_push(
                $items,
                '<nobr>
                    </a>
                    <a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>',

                '</a><a class="text-info mx-1" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                    ' . $ticket->id . '</a>',

                $ticket->patient()->first()->id,
                $ticket->department_id != null ?  ucfirst(Role::where('id', $ticket->department_id)->first()->name) : '',
                ucfirst($ticket->status),
                $ticket->remarks,
                Carbon::parse($ticket->created_at)->format('d F, Y'),
                Carbon::parse($ticket->updated_at)->format('d F, Y'),
                $ticket->call_strike,
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
            );
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('tickets.index', compact('heads', 'config'));
    }

    public function missingInfo()
    {
        $tickets = Ticket::where('honos', null)->orWhere('location', null)->get();
        //dd($tickets);
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Patient ID',
            'Status',
            'Remarks',
            'Created At',
            'Updated At',
            'Strike',
            'Mono/Multi ZD',
            'Mono/Multi Screening',
            'Intake or Therapist',
            // ['label' => 'Phone', 'width' => 40],
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


        ];



        $data = [];

        foreach ($tickets as $ticket) {
            $items = [];

            array_push($items, '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('tickets.destroy', ['ticket' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>', '</a><a class="text-info mx-1" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                    ' . $ticket->id . '</a>', $ticket->patient()->first()->id, $ticket->status != 'cancelled' && $ticket->department_id != null ?  ucfirst(Role::where('id', $ticket->department_id)->first()->name) . " " . ucfirst($ticket->status) : ucfirst($ticket->status), $ticket->remarks, Carbon::parse($ticket->created_at)->format('d F, Y'), Carbon::parse($ticket->updated_at)->format('d F, Y'), $ticket->call_strike, $ticket->mono_multi_zd, $ticket->mono_multi_screening, $ticket->intake_or_therapist, $ticket->tresonit_number, $ticket->datum_intake, $ticket->datum_intake_2, $ticket->nd_account, $ticket->avc_alfmvm_sbg, $ticket->honos, $ticket->berha_intake, $ticket->rom_start, $ticket->rom_end, $ticket->berha_end, $ticket->vtcb_date, $ticket->closure, $ticket->aanm_intake_1, $ticket->location,);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('tickets.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $screener = Role::where('name', 'screener')->first();
        $patients = Patient::all();
        return view('tickets.create', compact(['screener', 'patients']));
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
        // dd($data);

        try {

            $ticket = new Ticket();

            if ($data['location'] != null &&  $data['honos'] != null) {
                $ticket->department_id = $data['select-department'];
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
            $ticket->status = 'open';
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
            $ticket->language = $data['language-treatment'];
            // $ticket->files = $data[''];

            $ticket->save();

            //attachment save

            $files = $request->file('files');

            //dd($files[0]->getClientOriginalName());
            if ($files) {
                foreach ($files as $file) {

                    //$image = $request->file('image');
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
            // return response()->json(['message' => $request]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
            // return response()->json(['message' => $request], 500);
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
        //$comments = Post::find(1)->comments;
        // $attachment = Ticket::find($id)->attachments;
        // dd($attachment);

        $roles = ['screener', 'pib', 'pit', 'heranmelding', 'appointment'];
        // dd($roles);
        $matchingRoles = Role::whereIn('name', $roles)->get();

        //dd($matchingRoles);

        $ticket = Ticket::where('id', $id)->first();
        $patient = $ticket->patient()->first();
        $patients = Patient::all();


        $countries = Countries::all();

        $attachments = $ticket->attachments;

        return view('tickets.show', compact('patients', 'matchingRoles', 'ticket', 'patient', 'attachments', 'countries'));
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


            if ($data['location'] != null &&  $data['honos'] != null) {
                $ticket->department_id = $data['select-department'];
            }

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
            // $ticket->comment = $data['comments'];
            $ticket->language = $data['language-treatment'];
            // $ticket->files = $data[''];

            $ticket->save();
            if ($data['comments'] != null) {
                $history = new TicketHistory();

                $history->ticket_id = $id;
                $history->comment = $data['comments'];

                $history->save();
            }

            //attachment update

            $files = $request->file('files');

            if ($files) {
                foreach ($files as $file) {


                    // $attachment = new Attachment();
                    // $attachment->ticket_id = $ticket->id;
                    // $attachment->attatchment = $file->store('attachments_folder');
                    // $attachment->save();

                    //..............
                    //$image = $request->file('image');
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
            return response()->json($data, 500);
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

    public function updateAssignedTo(Request $request)
    {
        $rowId = $request->input('rowId');
        $assignedTo = $request->input('assignedTo');

        // Retrieve the record from the database based on the provided ID
        $record = Ticket::find($rowId);

        if ($record) {
            // Update the assigned_to value with the provided assignedTo value
            $record->assigned_staff = $assignedTo;
            $record->status = 'onhold';
            $record->save();

            // history add

            $history = new TicketHistory();

            $assigneduser = User::where('id', $assignedTo)->first();

            $history->ticket_id = $rowId;
            $history->comment = 'Updated to the user' . $assigneduser->first_name . " " . $assigneduser->last_name;
            $history->save();

            // histiry add end

            return response()->json(['message' => 'Assigned To updated successfully'], 200);
        }

        // return response()->json(['message' => 'Record not found'], 404);
    }

    public function getUsersByRole(Request $request)
    {
        try {
            $role = $request->input('role');

            $roleName = $role != null ? Role::where('id', $role)->first()->name : '';

            $admin = User::role('admin')->get();

            // Retrieve the users based on the selected role
            $users = $roleName != '' ? User::role($roleName)->get() : null;

            $newUsers = array_merge($users != null ? $users->toArray() : [], $admin->toArray());

            return response()->json(['users' => $newUsers]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function cancelTicket(Request $request)
    {
        try {


            $ticket = Ticket::where('id', $request->input('id'))->first();

            $ticket->status = 'cancelled';
            $ticket->department_id = null;
            $ticket->assigned_staff = null;
            $ticket->is_cancelled = true;
            $ticket->cancel_reason = $request->input('reason');

            $ticket->save();


            // history add

            $history = new TicketHistory();

            $assigneduser = User::where('id', $ticket->assigned_staff)->first();

            $history->ticket_id = $request->input('id');
            $history->comment = 'The ticket has been cancelled by ' . Auth::user()->name . "<br>" . 'for "' . $request->input('reason') . '"';
            $history->save();

            if ($request->input('mailId') != null) {
                $emailTemplate = EmailTemplate::where('id', $request->input('mailId'))->first();

                $userEmail = $ticket->patient()->first()->user()->first()->email;

                // Retrieve the dynamic values from the fetched email template
                $subject = $emailTemplate->mail_subject;
                $body = $emailTemplate->mail_body;
                $recipientName = $ticket->patient()->first()->user()->first()->name;

                $mail = new CancelMail();
                $mail->subject = $subject;
                $mail->body = $body;
                $mail->recipientName = $recipientName;

                Mail::to($userEmail)->send($mail);
            }

            // histiry add end

            return response()->json(['message' => 'Tciket Successfully Cancelled']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function sendEmailForCancel(Request $request)
    {
        try {
            $ticket = Ticket::where('id', $request->input('id'))->first();

            if ($request->input('mailId') != null) {

                // history add
                $history = new TicketHistory();
                $history->ticket_id = $request->input('id');
                $history->comment = $request->input('reason');
                $history->save();


                $emailTemplate = EmailTemplate::where('id', $request->input('mailId'))->first();

                $userEmail = $ticket->patient()->first()->user()->first()->email;

                $patient_name = $ticket->patient->user->name;

                // Retrieve the dynamic values from the fetched email template
                $subject = $emailTemplate->mail_subject;
                $body = $emailTemplate->mail_body;

                $body = ($patient_name !== null) ? str_replace("#patientName", $patient_name, $body) : $body;


                //dd($body);

                $recipientName = $ticket->patient()->first()->user()->first()->name;

                $mail = new CancelMail();
                $mail->subject = $subject;
                $mail->body = $body;
                $mail->recipientName = $recipientName;

                Mail::to($userEmail)->send($mail);
            }

            // histiry add end

            return response()->json(['message' => 'Mail Send']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getCancelledTickets()
    {
        $tickets = Ticket::where('status', 'cancelled')->get();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Patient ID',
            'Status',
            'Strike',
            'Remarks',
            'Created At',
            'Updated At',
            'Mono/Multi ZD',
            'Mono/Multi Screening',
            'Intake or Therapist',
            // ['label' => 'Phone', 'width' => 40],
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



        ];



        $data = [];

        foreach ($tickets as $ticket) {
            $items = [];

            $department = Role::where('id', $ticket->department_id)->first();
            $name = $department ? ucfirst($department->name) : '';

            array_push($items, '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('tickets.destroy', ['ticket' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>', '</a><a class="text-info mx-1" href="' . route('tickets.show', ['ticket' => $ticket->id]) . '">
                    ' . $ticket->id . '</a>', $ticket->patient()->first()->id, $ticket->status != 'cancelled' && $ticket->department_id != null ?  ucfirst($name) . " " . ucfirst($ticket->status) : ucfirst($ticket->status), $ticket->call_strike, $ticket->remarks, Carbon::parse($ticket->created_at)->format('d F, Y'), Carbon::parse($ticket->updated_at)->format('d F, Y'), $ticket->mono_multi_zd, $ticket->mono_multi_screening, $ticket->intake_or_therapist, $ticket->tresonit_number, $ticket->datum_intake, $ticket->datum_intake_2, $ticket->nd_account, $ticket->avc_alfmvm_sbg, $ticket->honos, $ticket->berha_intake, $ticket->rom_start, $ticket->rom_end, $ticket->berha_end, $ticket->vtcb_date, $ticket->closure, $ticket->aanm_intake_1, $ticket->location,);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('tickets.index', compact('heads', 'config'));
    }

    public function getHistories(Request $request)
    {
        try {
            $id = $request->input('id');

            $histories = TicketHistory::where('ticket_id', $id)->get();


            return response()->json(['histories' => $histories]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getReferral()
    {
        return view('tickets.createFromReferral');
    }







    public function createTicketFromReferral(Request $request)
    {
        $request->validate([
            'referral_file' => 'required|mimes:pdf|max:2048', // Adjust max file size as needed
        ]);


        $pdfFilePath = $request->file('referral_file')->store('uploads', 'public');

        // Get the public path of the stored file
        $publicFilePath = Storage::disk('public')->path($pdfFilePath);
        Log::info('File path: ' . $pdfFilePath);

        // Assuming the Flask server is running on http://127.0.0.1:5000
        $flaskServerUrl = env('PYTHON_API_URL', 'http://44.219.8.97:5080') . '/extract';

        // dd($flaskServerUrl);

        // Make a POST request to the Flask server
        $client = new Client();
        $response = $client->post($flaskServerUrl, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($publicFilePath, 'r'),
                    'filename' => basename($publicFilePath),
                ],
            ],
        ]);

        // Get the JSON response from the Flask server
        $jsonResponse = $response->getBody()->getContents();

        $jsonData = $jsonResponse;

        // Decode the JSON data into an associative array
        $data = json_decode($jsonData, true);

        // Get the "Adres" value
        $adresValue = $data['keys']['Adres'];
        $bsn = $data['keys']['BSN'];
        $geboortedatum = $data['keys']['Geboortedatum'];
        $naam = $data['keys']['Naam'];
        $madical_history = $data['keys']['Problems'];
        $tel = $data['keys']['Tel'];
        $insurence = $data['keys']['Verzekeringsnummer'];

        $zipcity = $data['keys']['Woonplaats'];

        $zd_number = $data['keys']['ZD_number'];

        $combinedProblems = implode("\n", $madical_history); // Combine with line breaks

        //$inputString = "3014SH Rotterdam";
        //$zipcity = "3014SH Rotterdam";
        $zipcity = trim($zipcity);
        $parts = explode(' ', $zipcity);
        if ($parts > 1) {
            $zip = $parts[0];
            $city = $parts[1];
        } elseif ($parts < 2) {
            $zip = $parts[0];
        }
        //dd($city);



        //dd($adresValue, $bsn, $geboortedatum, $tel, $zd_number);


        //search this bsn number in patient BSN_number table , if not availabel ,create user, patient, ticket,
        // if not just create ticket againest that patient


        //$bsn = $data['keys']['BSN'];





        //$data = [];
        try {
            //search this bsn number in patient table , BSN_number column ,
            $existing_patient = Patient::where('BSN_number', $bsn)->first();


            if ($existing_patient) {

                //$user_id = $patient->user_id;
                //dd($user_id);
                // create only ticket

                // save ticket
                //$patient->user_id = $patient->user_id;

                $ticket = new Ticket();
                $ticket->department_id = null;
                $ticket->patient_id = $existing_patient->id;
                $ticket->zd_id = $zd_number;
                $ticket->save();
            } else {
                // create user, patient , ticket
                //dd($bsn);
                $user = new User();
                $patient = new Patient();
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $serialLength = 8; // Adjust the length as needed
                $userSerialNo = 'misi';

                for ($i = 0; $i < $serialLength; $i++) {
                    $randomChar = $characters[rand(0, strlen($characters) - 1)];
                    $userSerialNo .= $randomChar;
                }

                while (User::where('user_serial_no', $userSerialNo)->exists()) {
                    $userSerialNo = 'misi';

                    for ($i = 0; $i < $serialLength; $i++) {
                        $randomChar = $characters[rand(0, strlen($characters) - 1)];
                        $userSerialNo .= $randomChar;
                    }
                }


                //generate unique user name

                do {
                    $randomString = Str::random(10); // Generate a random string
                } while (User::where('user_name', $randomString)->exists());

                // save user
                $user->user_serial_no = $userSerialNo;
                //$user->first_name = $data['first-name'];
                //$user->last_name = $data['last-name'];
                $user->name = $naam;
                //dd($naam);

                $user->user_name = $randomString;

                $user->phone = $tel;

                //$user->email = $data['email'];
                $user->password = Hash::make(123456);
                //$user->sex = $data['sex'];

                $user->date_of_birth = $geboortedatum;

                //$user->profile_image = $filename_path;


                // $user->age = $data['age'];
                //$user->status = $data['status'];
                //$user->marital_status = $data['marital-status'];

                $user->save();



                // save patient

                $patient->user_id = $user->id;
                //$patient->blood_group = $data['blood-group'];
                //$patient->country = $data['country'];

                $patient->residential_address = $adresValue;

                $patient->medical_history = $combinedProblems;
                $patient->insurance_number = $insurence;
                //$patient->occupation = $data['occupation'];

                // $patient->status = $data['status']; //commented

                //$patient->alternative_phone = $data['alt-phone-number'];
                // $patient->emergency_contact = $data['emergency-contact'];
                //$patient->remarks = $data['remarks'];
                $patient->city_or_state = $city;
                $patient->area = $zip;
                //$patient->DOB_number = $data['dob-number'];

                $patient->BSN_number = $bsn;

                //$patient->file_type = $data['file-type'];
                // $patient->file = $data['']; //commented

                $patient->save();


                // save ticket


                $ticket = new Ticket();
                $ticket->department_id = 4;
                $ticket->patient_id = $patient->id;
                $ticket->zd_id = $zd_number;
                $ticket->save();
            }

            //return response()->json(['message' => 'Data saved successfully']);
            return redirect()->route('tickets.show', ['ticket' => $ticket->id]);
        } catch (\Throwable $th) {

            return response()->json($th->getMessage(), 500);
        }

        //dd($adresValue, $bsn);

        // Return the JSON response as the HTTP response
        //dd($jsonResponse);
    }
}
