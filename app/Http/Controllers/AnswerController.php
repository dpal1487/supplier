<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerListResources;
use Inertia\Inertia;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\AnswerResources;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::get();
        $answers = new Answer();
        if (!empty($request->q)) {
            $answers = $answers
                ->whereHas('question', function ($q) use ($request) {
                    $q->where('question_key', 'like', "%$request->q%");
                })
                ->orWhere('answer', 'like', "%$request->q%");
        }
        return Inertia::render('Answer/Index', [
            'answers' => AnswerListResources::collection($answers->paginate(10)->appends($request->all())),
            'questions' => $questions
        ]);
    }

    public function create()
    {
        $questions = Question::get();
        return Inertia::render('Answer/Form', ['questions' => $questions]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $answer = Answer::create([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);
        if ($answer) {
            if ($request->questionpage) {
                return redirect("/question/$request->question")->with('flash', ['message' => 'Answer Successfully created.']);
            }
            return response()->json(['success' => true, 'message' => 'Answer created successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Answer not created']);
        }
    }

    public function edit($id)
    {

        $questions = Question::get();
        $answer = Answer::find($id);

        return response()->json([
            'answer' => new AnswerResources($answer),
            'questions' => $questions,
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }

        $answer = Answer::where(['id' => $request->id])->update([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);
        if ($answer) {
            if ($request->questionpage) {
                return redirect('question/' . $request->question)->with('flash', updateMessage('Answer'));
            }
            // return redirect('answers')->with('flash', updateMessage('Answer'));
            return response()->json(updateMessage('Answer'));
        } else {
            return response()->json(['success' => true, 'message' => 'Answer not updated']);
        }
    }

    public function destroy(Answer $answer)
    {

        if ($answer->delete()) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $answer = Answer::whereIn('id', $request->ids)->delete();

        if ($answer) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
