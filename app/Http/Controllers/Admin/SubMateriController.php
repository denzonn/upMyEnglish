<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\SubMateri;
use App\Models\SubMateriImage;
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

        if ($request->hasFile('audio')) {
            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid() . "." . $audioExtension;
            $data['audio'] = $images->storeAs('sub_materi_audio', $audioFileName, 'public');
        }

        $subMateri = SubMateri::create($data);

        if ($request->hasFile('photo')) {
            $images = $request->file('photo');

            foreach ($images as $image) {
                $extension = $image->getClientOriginalExtension();
                $file_name = uniqid() . "." . $extension;
                $path = $image->storeAs('submateri', $file_name, 'public');

                SubMateriImage::create([
                    'sub_materi_id' => $subMateri->id,
                    'photo' => $path,
                ]);
            }
        }

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
        $photos = SubMateriImage::where('sub_materi_id', $data->id)->get();

        return view('pages.submateri.edit', compact('data', 'materi', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $submateri = SubMateri::findOrFail($id);

        if ($request->hasFile('photo')) {
            $photo = SubMateriImage::where('sub_materi_id', $submateri->id)->get();

            foreach ($photo as $p) {
                Storage::disk('public')->delete($p->photo);

                $p->delete();
            }

            $images = $request->file('photo');

            foreach ($images as $image) {
                $extension = $image->getClientOriginalExtension();
                $file_name = uniqid() . "." . $extension;
                $path = $image->storeAs('submateri', $file_name, 'public');

                SubMateriImage::create([
                    'sub_materi_id' => $id,
                    'photo' => $path,
                ]);
            }
        }

        if ($request->hasFile('audio')) {

            if ($submateri->audio) {
                Storage::disk('public')->delete($submateri->audio);
            }

            $images = $request->file('audio');
            $audioExtension  = $images->getClientOriginalExtension();
            $audioFileName  = uniqid() . "." . $audioExtension;
            $data['audio'] = $images->storeAs('sub_materi_audio', $audioFileName, 'public');
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

        $photos = SubMateriImage::where('sub_materi_id', $id)->get();

        if ($photos) {
            foreach ($photos as $p) {
                Storage::disk('public')->delete($p->photo);

                $p->delete();
            }
        }

        $submateri->delete();

        return redirect()->route('submateri.index')->with('toast_success', "Sub Materi $name berhasil dihapus");
    }
}
