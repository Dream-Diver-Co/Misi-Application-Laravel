<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
use App\Models\User;
use App\Models\WorkDayTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Countries\Package\Countries;

class TherapistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:therapist|admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $therapists = Therapist::all();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Name',
            'Type',
            'Status',
            // ['label' => 'Phone', 'width' => 40],
            'Email',
            'Phone',
            'Alternative Phone',
            'Emergency Contact',
            'Sex',
            'Date of Birth',
            'Marital Status',
            'Patient Source',
            'Blood Group',
            'Country',
            'Residential Address',
            'Insurance Number',
            'City/State',
            'Area',
            'DOB Number',
            'BSN Number',
            'Remarks'


        ];



        $data = [];

        foreach ($therapists as $therapist) {
            $items = [];

            array_push($items, '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('therapists.destroy', ['therapist' => $therapist->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('therapists.show', ['therapist' => $therapist->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>', $therapist->id, $therapist->user()->first()->name, $therapist->therapist_type, $therapist->user()->first()->status, $therapist->user()->first()->email, $therapist->user()->first()->phone, $therapist->alternative_phone, $therapist->emergency_contact, $therapist->user()->first()->sex, $therapist->user()->first()->date_of_birth, $therapist->user()->first()->marital_status, $therapist->therapist_source, $therapist->blood_group, $therapist->country, $therapist->residential_address, $therapist->insurance_number, $therapist->city_or_state, $therapist->area, $therapist->DOB_number, $therapist->BSN_number, $therapist->remarks);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('therapists.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::all();
        return view('therapists.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->all();
        //$data['profile-image'] = request()->file('profile-image')->store('users_image');

        $filename_path = null;
        if (isset($data['profile-image']) && $data['profile-image']) {
            $file = $data['profile-image'];

            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($name, PATHINFO_FILENAME) . time() . '.' . $extension;
            $filename_path = request()->file('profile-image')->storeAs('users_image', $filename);
        }

        try {
            $user = new User();
            $therapist = new Therapist();
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

            // save user
            $user->user_serial_no = $userSerialNo;
            $user->name = $data['name'];
            //$user->first_name = $data['first-name'];
            //$user->last_name = $data['last-name'];
            $user->user_name = $data['user-name'];
            $user->phone = $data['phone-number'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->sex = $data['sex'];
            $user->date_of_birth = $data['dob'];
            $user->profile_image = $filename_path;
            // $user->age = $data['age'];
            $user->status = $data['status'];
            $user->marital_status = $data['marital-status'];

            $user->save();

            // save patient
            $therapist->user_id = $user->id;
            $therapist->therapist_type = $data['therapist-type'];;
            $therapist->blood_group = $data['blood-group'];
            $therapist->country = $data['country'];
            $therapist->residential_address = $data['residential-address'];
            $therapist->insurance_number = $data['insurance-number'];
            // $therapist->status = $data['status'];
            $therapist->alternative_phone = $data['alt-phone-number'];
            $therapist->emergency_contact = $data['emergency-contact'];
            $therapist->remarks = $data['remarks'];
            $therapist->city_or_state = $data['city-state'];
            $therapist->area = $data['area'];
            //$therapist->DOB_number = $data['dob-number'];
            $therapist->BSN_number = $data['bsn-number'];
            // $therapist->file = $data[''];


            $therapist->save();

            $WORKDAYTIME = new WorkDayTime();

            $WORKDAYTIME->start_time = '09:00:00';
            $WORKDAYTIME->end_time = '17:00:00';

            $WORKDAYTIME->weekly_holidays = json_encode(['6', '0']);

            $WORKDAYTIME->therapist_id = $therapist->id;

            $WORKDAYTIME->save();



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
        $therapist = Therapist::where('id', $id)->first();
        $countries = Countries::all();

        return view('therapists.show', compact('therapist', 'countries'));
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
        //$data['profile-image'] = request()->file('profile-image')->store('users_image');
        //dd($data);

        // $file = $data['profile-image'];
        $filename_path = null;
        if (isset($data['profile-image']) && $data['profile-image']) {
            $file = $data['profile-image'];

            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($name, PATHINFO_FILENAME) . time() . '.' . $extension;
            $filename_path = request()->file('profile-image')->storeAs('users_image', $filename);
        }


        try {
            $therapist = Therapist::where('id', $id)->first();
            $user = $therapist->user()->first();
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $serialLength = 8; // Adjust the length as needed
            $userSerialNo = 'misi';

            // for ($i = 0; $i < $serialLength; $i++) {
            //     $randomChar = $characters[rand(0, strlen($characters) - 1)];
            //     $userSerialNo .= $randomChar;
            // }

            // while (User::where('user_serial_no', $userSerialNo)->exists()) {
            //     $userSerialNo = 'misi';

            //     for ($i = 0; $i < $serialLength; $i++) {
            //         $randomChar = $characters[rand(0, strlen($characters) - 1)];
            //         $userSerialNo .= $randomChar;
            //     }
            // }

            // save user
            // $user->user_serial_no = $userSerialNo;

            $user->name = $data['name'];
            //$user->first_name = $data['first-name'];
            //$user->last_name = $data['last-name'];
            $user->user_name = $data['user-name'];
            $user->phone = $data['phone-number'];
            $user->email = $data['email'];
            // $user->password = Hash::make($data['password']);
            $user->sex = $data['sex'];
            $user->date_of_birth = $data['dob'];
            $user->profile_image = $filename_path;
            // $user->age = $data['age'];
            $user->status = $data['status'];
            $user->marital_status = $data['marital-status'];

            $user->save();

            // save patient
            $therapist->user_id = $user->id;
            $therapist->therapist_type = $data['therapist-type'];;
            $therapist->blood_group = $data['blood-group'];
            $therapist->country = $data['country'];
            $therapist->residential_address = $data['residential-address'];
            $therapist->insurance_number = $data['insurance-number'];
            // $therapist->status = $data['status'];
            $therapist->alternative_phone = $data['alt-phone-number'];
            $therapist->emergency_contact = $data['emergency-contact'];
            $therapist->remarks = $data['remarks'];
            $therapist->city_or_state = $data['city-state'];
            $therapist->area = $data['area'];
            //$therapist->DOB_number = $data['dob-number'];
            $therapist->BSN_number = $data['bsn-number'];
            // $therapist->file = $data[''];


            $therapist->save();



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
