<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResources;
use Inertia\Inertia;
use App\Models\Industry;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResources;
use App\Models\Answer;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = new Question();
        $industries = Industry::get();
        if (!empty($request->q)) {
            $questions = $questions
                ->whereHas('industry', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                })
                ->orWhere('question_key', 'like', "%$request->q%")
                ->orWhere('text', 'like', "%$request->q%")
                ->orWhere('language', 'like', "%$request->q%");
        }
        return Inertia::render('Question/Index', [
            'questions' => QuestionResources::collection($questions->paginate(10)->appends($request->all())),
            'industries' => $industries
        ]);
    }
    public function create()
    {
        $industries = Industry::get();
        return Inertia::render('Question/Form', ['industries' => $industries]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'question_key' => 'required',
            'text' => 'required',
            'type' => 'required',
            'industry' => 'required',
            'language' => 'required',
        ]);

        $question = question::create([
            'question_key' => $request->question_key,
            'text' => $request->text,
            'type' => $request->type,
            'industry_id' => $request->industry,
            'language' => $request->language,
        ]);
        if ($question) {

            return response()->json(createMessage('Question'));
            // return redirect('question')->with('flash', createMessage('Question'));
        }
        return response()->json(errorMessage());

        // return redirect('question')->with('flash', errorMessage());
    }

    public function show($id)
    {
        $question = Question::find($id);
        $answers = Answer::where('question_id', $question->id)->get();
        return Inertia::render('Question/Overview', [
            'question' => new QuestionResources($question),
            'answers' => AnswerResources::collection($answers),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $industries = Industry::get();
        $question = Question::find($id);
        return response()->json([
            'question' => new questionResources($question),
            'industries' => $industries,
        ]);

        // return Inertia::render('Question/Form', [
        //     'question' => new questionResources($question),
        //     'industries' => $industries,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'question_key' => 'required',
            'text' => 'required',
            'type' => 'required',
            'industry' => 'required',
            'language' => 'required',
        ]);

        $data = Question::where(['id' => $request->id])->first();
        if ($data) {


            $question = $data->update([
                'question_key' => $request->question_key,
                'text' => $request->text,
                'type' => $request->type,
                'industry_id' => $request->industry,
                'language' => $request->language,
            ]);
            if ($question > 0) {
                return response()->json(updateMessage('Question'));
            } else {
                return response()->json(errorMessage());
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // dd($id);

        if ($question->delete()) {
            return response()->json(['success' => true, 'message' => 'Question has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }

    public function selectDelete(Request $request)
    {
        $question = Question::whereIn('id', $request->ids)->delete();

        if ($question) {
            return response()->json(['success' => true, 'message' => 'Questions has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
