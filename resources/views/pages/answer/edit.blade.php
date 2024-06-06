@extends('layouts.app')

@section('title')
    Edit SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('answer-index', $data->question_id) }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Edit Opsi Jawaban</div>
        </div>
        <div>
            <form action="{{ route('answer-update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Opsi Jawaban</label>
                        <input type="text" placeholder="Masukkan Opsi Jawaban" name="answer"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->answer }}" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="materi_id">Pilihan Jawaban</label>
                        <select name="is_correct" id="materi_id" class="bg-transparent border px-4 py-[8px] rounded-md">
                            <option value="1" {{ $data->is_correct === 1 ? 'selected' : '' }}>Benar</option>
                            <option value="0" {{ $data->is_correct === 0 ? 'selected' : '' }}>Salah</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Update Opsi Jawaban</button>
                </div>
            </form>
        </div>
    </div>
@endsection
