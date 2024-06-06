@extends('layouts.app')

@section('title')
    Detail Jawaban User
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('user-answer-submateri', $data->user_id) }}" class="px-3 py-1 bg-primary text-white rounded-md"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-2xl font-semibold">Sub Materi : {{ $data->subMateri->name }}</div>
        </div>
        <div class="mt-2">Total Nilai : {{ $data->total }}</div>
        <div class="space-y-3 mt-4">
            @foreach ($data->detailAnswer as $key => $item)
                <div class="text-lg">{{ $key + 1 }}. Pertanyaan : {{ $item->question->question }}</div>
                <div class="{{ $item->answer->is_correct == 1 ? 'text-green-500' : 'text-red-500' }}">Jawaban :
                    {{ $item->answer->answer }}</div>
            @endforeach
        </div>
    </div>
@endsection
