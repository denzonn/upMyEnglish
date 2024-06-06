<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SubMateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.submateri.index');
    }

    public function getData()
    {
        $submateri = SubMateri::with(['materi'])->orderBy('materi_id')->get();

        return DataTables::of($submateri)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materi = Materi::all();

        return view('pages.submateri.create', compact('materi'));
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

            $file_name = $data['name'] . "-" . uniqid() . "." . $extension;

            $data['photo'] = $images->storeAs('submateri', $file_name, 'public');
        }

        SubMateri::create($data);

        return redirect()->route('submateri.index')->with('toast_success', 'Sub Materi berhasil ditambahkan');
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
        $data = SubMateri::findOrFail($id);
        $materi = Materi::all();

        return view('pages.submateri.edit', compact('data','materi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $submateri = SubMateri::findOrFail($id);

        if ($request->hasFile('photo')) {
            if($submateri->photo){
                Storage::disk('public')->delete($submateri->photo);
            }

            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $file_name = $data['name'] . "-" . uniqid() . "." . $extension;

            $data['photo'] = $images->storeAs('submateri', $file_name, 'public');
        }

        $submateri->update($data);

        return redirect()->route('submateri.index')->with('toast_success', 'Sub Materi berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submateri = SubMateri::findOrFail($id);
        $name = $submateri->name;

        if ($submateri->photo) {
            Storage::disk('public')->delete($submateri->photo);
        }

        $submateri->delete();

        return redirect()->route('submateri.index')->with('toast_success', "Sub Materi $name berhasil dihapus");
    }
}
