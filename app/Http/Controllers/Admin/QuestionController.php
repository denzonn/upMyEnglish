<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.question.index');
    }

    public function getData()
    {
        $question = Question::with(['submateri'])->orderBy('sub_materi_id')->get();

        return DataTables::of($question)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $submateri = SubMateri::all();

        return view('pages.question.create', compact('submateri'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid() . "." . $extension;
            $data['photo'] = $images->storeAs('question', $file_name, 'public');
        }

        if ($request->hasFile('audio')) {
            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid() . "." . $audioExtension;
            $data['audio'] = $images->storeAs('question', $audioFileName, 'public');
        }

        Question::create($data);

        return redirect()->route('question.index')->with('toast_success', 'Pertanyaan berhasil ditambahkan');
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
        $data = Question::findOrFail($id);
        $submateri = SubMateri::all();

        return view('pages.question.edit', compact('data', 'submateri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $question = Question::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($question->photo) {
                Storage::disk('public')->delete($question->photo);
            }

            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid() . "." . $extension;
            $data['photo'] = $images->storeAs('question', $file_name, 'public');
        }

        if ($request->hasFile('audio')) {

            if ($question->audio) {
                Storage::disk('public')->delete($question->audio);
            }

            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid() . "." . $audioExtension;
            $data['audio'] = $images->storeAs('question', $audioFileName, 'public');
        }

        $question->update($data);

        return redirect()->route('question.index')->with('toast_success', 'Pertanyaan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);

        if ($question->photo) {
            Storage::disk('public')->delete($question->photo);
        }

        if ($question->audio) {
            Storage::disk('public')->delete($question->audio);
        }

        $question->delete();

        return redirect()->route('question.index')->with('toast_success', 'Pertanyaan berhasil Dihapus');
    }
}
