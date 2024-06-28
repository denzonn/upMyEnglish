<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Example;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;
use Yajra\DataTables\DataTables;

class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($sub_materi_id)
    {
        $data = SubMateri::findOrFail($sub_materi_id);

        return view('pages.submateri.example.index', compact('data'));
    }

    public function getData($sub_materi_id)
    {
        $example = Example::with(['subMateri'])->where('sub_materi_id', $sub_materi_id)->get();

        return DataTables::of($example)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sub_materi_id)
    {
        $data = SubMateri::findOrFail($sub_materi_id);

        return view('pages.submateri.example.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $id = $data['sub_materi_id'];

        if ($request->hasFile('audio')) {
            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid() . "." . $audioExtension;
            $data['audio'] = $images->storeAs('example_audio', $audioFileName, 'public');
        }

        if ($request->hasFile('photo')) {
            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid() . "." . $extension;
            $data['photo'] = $images->storeAs('example_photo', $file_name, 'public');
        }
        Example::create($data);


        return redirect()->route('example-index', ['sub_materi_id' => $request['sub_materi_id']]);
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
        $data = Example::findOrFail($id);

        return view('pages.submateri.example.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $example = Example::findOrFail($id);

        if($request['delete_audio']){
            if($example->audio){
                Storage::disk('public')->delete($example->audio);
            }
            $data['audio'] = null;
        }

        if($request['delete_photo']){
            if($example->photo){
                Storage::disk('public')->delete($example->photo);
            }
            $data['photo'] = null;
        }

        if ($request->hasFile('audio')) {
            if($example->audio){
                Storage::disk('public')->delete($example->audio);
            }

            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid(). ".". $audioExtension;
            $data['audio'] = $images->storeAs('example_audio', $audioFileName, 'public');
        }

        if ($request->hasFile('photo')) {
            if($example->photo){
                Storage::disk('public')->delete($example->photo);
            }

            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid(). ".". $extension;
            $data['photo'] = $images->storeAs('example_photo', $file_name, 'public');
        }

        $example->update($data);

        return redirect()->route('example-index', ['sub_materi_id' => $example['sub_materi_id']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $example = Example::findOrFail($id);
        if($example->audio){
            Storage::disk('public')->delete($example->audio);
        }
        if($example->photo){
            Storage::disk('public')->delete($example->photo);
        }
        $example->delete();

        return redirect()->route('example-index', ['sub_materi_id' => $example['sub_materi_id']]);
    }
}
