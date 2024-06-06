<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = Question::findOrFail($id);

        return view('pages.answer.index', compact('data'));
    }

    public function getData($question_id)
    {
        $answer = Answer::where('question_id', $question_id)
                     ->orderBy('is_correct', 'desc')
                     ->get();

        return DataTables::of($answer)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($question_id)
    {
        $data = Question::findOrFail($question_id);

        return view('pages.answer.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $answer = Answer::where('question_id', $request->input('question_id'))->get();

        if($request->input('is_correct') == 1){
            if ($answer->where('is_correct', 1)->count() > 0) {
                return redirect()->route('answer-create', ['question_id' => $data['question_id']])->with('toast_error', 'Opsi Jawaban Benar tidak boleh double');
            }
        }
        Answer::create($data);

        return redirect()->route('answer-index', ['question_id' => $data['question_id']])->with('toast_success', 'Opsi Jawaban berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Answer::findOrFail($id);

        return view('pages.answer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $answer = Answer::findOrFail($id);
        $answerCheck = Answer::where('question_id', $answer->question_id)->get();

        if($request->input('is_correct') == 1){
            if ($answerCheck->where('is_correct', 1)->count() > 0) {
                return redirect()->route('answer-edit', ['id' => $id])->with('toast_error', 'Opsi Jawaban Benar tidak boleh double');
            }
        }

        $answer->update($data);

        return redirect()->route('answer-index', ['question_id' => $answer->question_id])->with('toast_success', 'Opsi Jawaban berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $answer = Answer::findOrFail($id);
        $question_id = $answer->question_id;

        $answer->delete();

        return redirect()->route('answer-index', ['question_id' => $question_id])->with('toast_success', 'Opsi Jawaban berhasil dihapus');
    }
}
