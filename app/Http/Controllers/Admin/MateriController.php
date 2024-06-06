<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.materi.index');
    }

    public function getData()
    {
        $materi = Materi::all();

        return DataTables::of($materi)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.materi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Materi::create($data);

        return redirect()->route('materi.index')->with('toast_success', 'Materi berhasil ditambahkan');
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
        $data = Materi::findOrFail($id);

        return view('pages.materi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        Materi::findOrFail($id)->update($data);

        return redirect()->route('materi.index')->with('toast_success', 'Materi berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Materi::findOrFail($id)->delete();

        return redirect()->route('materi.index')->with('toast_success', 'Materi berhasil Dihapus');
    }
}
