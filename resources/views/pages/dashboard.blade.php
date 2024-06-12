@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
<div class=" font-semibold text-white text-4xl mb-6">Dashboard</div>
    <div class="bg-white px-8 py-6 rounded-md text-gray-500">
        <div class="mb-4 text-2xl font-semibold ">Jumlah Data</div>
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-primary rounded-md p-4 text-white">
                <div class="text-2xl font-semibold">Materi</div>
                <div class="text-6xl font-semibold">{{ $materi }} <span class="text-lg font-medium">data</span></div>
            </div>
            <div class="bg-primary rounded-md p-4 text-white">
                <div class="text-2xl font-semibold">Sub Materi</div>
                <div class="text-6xl font-semibold">{{ $subMateri }} <span class="text-lg font-medium">data</span></div>
            </div>
            <div class="bg-primary rounded-md p-4 text-white">
                <div class="text-2xl font-semibold">Pertanyaan</div>
                <div class="text-6xl font-semibold">{{ $question }} <span class="text-lg font-medium">data</span></div>
            </div>
        </div>
    </div>
@endsection
