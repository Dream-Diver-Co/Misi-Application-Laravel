<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; // Replace with the actual model you want to search in
use App\Models\Patient;
use Spatie\Permission\Models\Role;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{


    public function searchById(Request $request)
    {

        $id = $request->input('id'); // Get the ID from the request
        $data = Ticket::find($id); // Replace YourModel with your actual model

        if ($data) {
            $roles = ['screener', 'pib', 'pit', 'heranmelding', 'appointment'];
            $matchingRoles = Role::whereIn('name', $roles)->get();
            $ticket = Ticket::where('id', $id)->first();
            $patient = $ticket->patient()->first();
            $patients = Patient::all();
            $countries = Countries::all();
            $attachments = $ticket->attachments;
            return view('tickets.show', compact('patients', 'matchingRoles', 'ticket', 'patient', 'attachments', 'countries'));
        } else {
            // No data found, stay on the same page and show an error message
            //session()->flash('success', 'No ticket found.');
            session()->flash('error', 'No ticket found.');
            return back();
        }
    }
}
