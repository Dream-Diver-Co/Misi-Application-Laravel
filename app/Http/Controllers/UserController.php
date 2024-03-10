<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $users = User::all();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'First Name',
            'Last Name',
            // ['label' => 'Phone', 'width' => 40],
            'Email',

        ];

        $data = [];

        foreach ($users as $user) {
            $items = [];

            array_push($items, '<nobr><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('users.destroy', ['user' => $user->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('users.show', ['user' => $user->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>', $user->id, $user->first_name, $user->last_name, $user->email);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,
            'columns' => [['orderable' => false, "targets" => 0], null, null, null],

        ];
        return view('users.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try {
            // $this->validate($request, [
            //     'first_name' => 'required',
            //     'last_name' => 'required',
            //     'email' => 'required|email|unique:users,email',
            //     'password' => 'required|same:confirm-password',
            //     'roles' => 'required'
            // ]);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            // $user = User::create($input);
            // $user->assignRole($request->input('roles'));
            $user = new User();
            $user->name = $input['name'];
            //$user->first_name = $input['first_name'];
            //$user->last_name = $input['last_name'];
            $user->email = $input['email'];
            $user->user_name = $input['user_name'];
            $user->phone = $input['phone'];
            $user->password = $input['password'];
            $user->marital_status = $input['marital_status'];
            $user->sex = $input['sex'];
            $user->date_of_birth = $input['dob'];
            // $user->first_name = $input['first-name'];

            $roles = $request->input('roles', []); // Get the selected roles from the request
            $user->syncRoles($roles);

            $user->save();

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
        $user = User::find($id);
        // dd($user->getRoleNames());
        $assignedRoles = $user->getRoleNames();
        $roles = Role::all();
        return view('users.show', compact('user', 'assignedRoles', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
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
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,' . $id,
        //     'password' => 'same:confirm-password',
        //     'roles' => 'required'
        // ]);

        // $input = $request->all();
        // if (!empty($input['password'])) {
        //     $input['password'] = Hash::make($input['password']);
        // } else {
        //     $input = Arr::except($input, array('password'));
        // }

        // $user = User::find($id);
        // $user->update($input);
        // DB::table('model_has_roles')->where('model_id', $id)->delete();

        // $user->assignRole($request->input('roles'));

        // return redirect()->route('users.index')
        //     ->with('success', 'User updated successfully');

        try {
            // $this->validate($request, [
            //     'first_name' => 'required',
            //     'last_name' => 'required',
            //     'email' => 'required|email|unique:users,email',
            //     'password' => 'required|same:confirm-password',
            //     'roles' => 'required'
            // ]);

            $user = User::where('id', $id)->first();

            $input = $request->all();
            if ($input['password'] != '') {
                $input['password'] = Hash::make($input['password']);
                $user->password = $input['password'];
            }

            // $user = User::create($input);
            // $user->assignRole($request->input('roles'));

            $user->name = $input['name'];
            //$user->first_name = $input['first_name'];
            //$user->last_name = $input['last_name'];
            $user->email = $input['email'];
            $user->user_name = $input['user_name'];
            $user->phone = $input['phone'];

            $user->marital_status = $input['marital_status'];
            $user->sex = $input['sex'];
            $user->date_of_birth = $input['dob'];
            // $user->first_name = $input['first-name'];

            $roles = $request->input('roles', []); // Get the selected roles from the request
            $user->syncRoles($roles);

            $user->save();

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
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
