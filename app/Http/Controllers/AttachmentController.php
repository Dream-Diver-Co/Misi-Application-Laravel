<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{



    public function destroy(Request $request)
    {
        //dd($request->all());
        Attachment::find($request->attachment_id)->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
