<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTamplateController extends Controller
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
        $templates = EmailTemplate::all();

        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Email Type',
            'Email Subject',
        ];



        $data = [];

        foreach ($templates as $template) {
            $items = [];
            array_push($items, '<nobr>
            <a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('email-templates.show', ['email_template' => $template->id]) . '">
            <i class="fa fa-lg fa-fw fa-eye"></i>
        </a></nobr>', $template->id, $template->mail_type, $template->mail_subject);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('emailTemplates.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emailTemplates.create');
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
            $data = $request->all();

            $template = new EmailTemplate();

            $emailBody = $data['email-body'];

            // $dom = new \DomDocument();
            // $dom->loadHtml($emailBody, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $imageFile = $dom->getElementsByTagName('img');

            // // $imageFile = iterator_to_array($imageFile); // Convert to an array

            // if ($imageFile->length > 0) {
            //     $imageFile = iterator_to_array($imageFile);
            //     foreach ($imageFile as $item => $image) {
            //         $srcAttribute = $image->getAttributeNode('src');
            //         if ($srcAttribute) {
            //             $srcValue = $srcAttribute->value;
            //             $dataUrlPattern = '/^data:image\/(\w+);base64,/';
            //             if (preg_match($dataUrlPattern, $srcValue, $matches)) {
            //                 $imageExtension = $matches[1];
            //                 $imageData = substr($srcValue, strpos($srcValue, ',') + 1);
            //                 $imageData = str_replace(' ', '+', $imageData);
            //                 $imageDecoded = base64_decode($imageData);
            //                 if ($imageDecoded !== false) {
            //                     $image_name = "/upload/" . time() . $item . '.' . $imageExtension;
            //                     $path = public_path() . $image_name;
            //                     file_put_contents($path, $imageDecoded);

            //                     $image->removeAttribute('src');
            //                     $image->setAttribute('src', $image_name);
            //                 }
            //             }
            //         }
            //     }
            // }

            // $emailBody = $dom->saveHTML();s

            $template->mail_name = $data['email-name'];
            $template->mail_type = $data['select-type'];
            $template->mail_subject = $data['email-subject'];
            $template->mail_body = $emailBody;

            $template->save();

            return response()->json(['message' => 'Successfully saved template']);
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
        $template = EmailTemplate::where('id', $id)->first();

        return view('emailTemplates.show', compact('template'));
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
        try {
            $data = $request->all();

            $template = EmailTemplate::where('id', $id)->first();

            $emailBody = $data['email-body'];

            // $dom = new \DomDocument();
            // $dom->loadHtml($emailBody, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $imageFile = $dom->getElementsByTagName('img');

            // // $imageFile = iterator_to_array($imageFile); // Convert to an array

            // if ($imageFile->length > 0) {
            //     $imageFile = iterator_to_array($imageFile);
            //     foreach ($imageFile as $item => $image) {
            //         $srcAttribute = $image->getAttributeNode('src');
            //         if ($srcAttribute) {
            //             $srcValue = $srcAttribute->value;
            //             $dataUrlPattern = '/^data:image\/(\w+);base64,/';
            //             if (preg_match($dataUrlPattern, $srcValue, $matches)) {
            //                 $imageExtension = $matches[1];
            //                 $imageData = substr($srcValue, strpos($srcValue, ',') + 1);
            //                 $imageData = str_replace(' ', '+', $imageData);
            //                 $imageDecoded = base64_decode($imageData);
            //                 if ($imageDecoded !== false) {
            //                     $image_name = "/upload/" . time() . $item . '.' . $imageExtension;
            //                     $path = public_path() . $image_name;
            //                     file_put_contents($path, $imageDecoded);

            //                     $image->removeAttribute('src');
            //                     $image->setAttribute('src', $image_name);
            //                 }
            //             }
            //         }
            //     }
            // }

            // $emailBody = $dom->saveHTML();

            $template->mail_name = $data['email-name'];
            $template->mail_type = $data['select-type'];
            $template->mail_subject = $data['email-subject'];
            $template->mail_body = $emailBody;

            $template->save();

            return response()->json(['message' => 'Successfully saved template']);
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

    public function getEmailForCancel(Request $request)
    {
        try {
            $emails = EmailTemplate::where('mail_type', $request->input('type'))->get();

            return response()->json($emails);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }


    public function getEmailForSend(Request $request)
    {
        try {
            $emails = EmailTemplate::where('mail_type', $request->input('type'))->get();

            return response()->json($emails);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
