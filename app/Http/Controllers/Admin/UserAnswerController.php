<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserAnswerController extends Controller
{
    public function index(){
        return view('pages.user-answer.index');
    }

    public function getData()
    {
        $user = User::all();

        return DataTables::of($user)->make(true);
    }

    public function submateri($user_id){
        $user = User::findOrFail($user_id);
        $answerDetail = UserAnswer::where('user_id', $user->id)->get();

        return view('pages.user-answer.index-submateri', compact('user', 'answerDetail'));
    }

    public function getDataSubMateri($user_id)
    {
        $user_answer = UserAnswer::where('user_id', $user_id)
            ->with(['subMateri.materi', 'detailAnswer.question', 'detailAnswer.answer'])
            ->get();

        return DataTables::of($user_answer)->make(true);
    }

    public function detail($user_answer){
        $data = UserAnswer::where('id', $user_answer)->with(['subMateri', 'detailAnswer.question', 'detailAnswer.answer'])->first();

        return view('pages.user-answer.detail', compact('data'));
    }
}
