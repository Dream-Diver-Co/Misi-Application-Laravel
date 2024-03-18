<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
        $questions = Question::all();
        $heads = [
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            'ID',
            'Question',
            'Question Type',



        ];



        $data = [];

        foreach ($questions as $question) {
            $items = [];

            array_push($items, '<nobr>
                    </a><a class="btn btn-xs btn-default text-danger mx-1 shadow" href="' . route('questions.destroy', ['question' => $question->id]) . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a><a class="btn btn-xs btn-default text-teal mx-1 shadow" href="' . route('questions.show', ['question' => $question->id]) . '">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></nobr>', $question->id, $question->question, $question->form_type,);
            array_push($data, $items);
        }

        $config = [
            'data' => $data,


        ];

        return view('questions.index', compact('heads', 'config'));
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
        try {
            $data = $request->all();

            $question = new Question();
            $question->question = $data['question'];
            $question->form_type = $data['select-type'];
            $question->answer_type = $data['select-answer-type'];
            $question->options = $data['options'];

            $question->save();

            return response()->json(['message' => 'Question saved successfully']);
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
        //
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

    public function createAnswers($questions, $formId,)
    {
        $formDataArray = [];
        foreach ($questions as $question) {
            $answerExists = Answer::where('form_id', $formId)->where('question_id', $question->id)->exists();


            if ($answerExists) {
                $answer = Answer::where('form_id', $formId)->where('question_id', $question->id)->first();

                $data = ['form_id' => $formId, 'question' => $question, 'answer' => $answer];

                array_push($formDataArray, $data);
            } else {
                $answer = new Answer();
                $answer->form_id = $formId;
                $answer->question_id = $question->id;
                $answer->answer = '';

                $answer->save();

                $data = ['form_id' => $formId, 'question' => $question->question, 'answer' => $answer->answer];
                array_push($formDataArray, $data);
            }
        }

        return response()->json($formDataArray);
    }

    public function toFormula(Request $request)
    {
        $ticketId = $request->input('ticketId');
        $formType = (int) $request->input('formType');

        $formExists = Form::where('ticket_id', $ticketId)->where('form_type', $formType)->exists();
        $questions = Question::where('form_type', $formType)->get();

        if ($formExists) {

            $formId = Form::where('ticket_id', $ticketId)->where('form_type', $formType)->first()->id;
            return $this->createAnswers($questions, $formId);
        } else {

            $form = new Form();

            $form->ticket_id = $ticketId;
            $form->form_type = $formType;

            $form->save();

            return $this->createAnswers($questions, $form->id);
        }
    }

    public function updateAnswers(Request $request)
    {
        $datas = $request->all();


        try {
            foreach ($datas as $id => $data) {
                $intId = (int) $id;
                $answer = Answer::where('id', $intId)->first();

                if ($answer) {
                    $answer->answer = $data != null ? $data : '';
                    $answer->save();
                }
            }

            return response()->json(['message' => 'answer updated']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
