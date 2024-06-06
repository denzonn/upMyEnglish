<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\UserAnswerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends BaseController
{
    public function index(){
        $data = UserAnswer::where('user_id', Auth::user()->id)
            ->with(['detailAnswer.question', 'detailAnswer.answer'])
            ->get();

        return $this->sendResponse($data, 'Success Get User Answer');
    }

    public function store(Request $request)
    {
        $data = $request->all();

         $subMateriId = 0;
         $total = 0;
         $userAnswerDetails = []; // Initialize as an empty array

         // Loop through each question_id and corresponding answer_id
         foreach ($data['question_id'] as $index => $questionId) {
             $question = Question::findOrFail($questionId);
             $answerId = $data['answer_id'][$index];
             $answer = Answer::where('question_id', $questionId)->where('id', $answerId)->first();

             $point = 0;
             if ($answer && $answer->is_correct == 1) {
                 // Add the question's weight (bobot) to the total
                 $total += $question->bobot;
                 $point = $question->bobot;
             }

             // Collect UserAnswerDetail for each answered question
             $userAnswerDetails[] = [
                 'question_id' => $questionId,
                 'answer_id' => $answerId,
                 'point' => $point,
             ];

             // Set the sub_materi_id (assuming all questions are from the same sub_materi)
             $subMateriId = $question->sub_materi_id;
         }

        $userAnswer = UserAnswer::create([
            'user_id' => Auth::user()->id,
            'sub_materi_id' => $subMateriId,
            'total' => $total,
        ]);

        foreach ($userAnswerDetails as $detail) {
            $detail['user_answer_id'] = $userAnswer->id;
            UserAnswerDetail::create($detail);
        }

        return $this->sendResponse($userAnswer, 'Successfully answer all questions');
    }
}
