@extends('layouts.app')

@section('title')
    Buat SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('answer-index', $data->id) }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Tambahkan Opsi Jawaban</div>
        </div>
        <div>
            <form action="{{ route('answer-store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Opsi Jawaban</label>
                        <input type="text" placeholder="Masukkan Opsi Jawaban" name="answer"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="materi_id">Pilihan Jawaban</label>
                        <select name="is_correct" id="materi_id" class="bg-transparent border px-4 py-[8px] rounded-md">
                            <option value="1">Benar</option>
                            <option value="0">Salah</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="question_id" value="{{ $data->id }}"
                    class="w-full border px-4 py-[6px] rounded-md bg-transparent" required />
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Tambah Opsi Jawaban</button>
                </div>
            </form>
        </div>
    </div>
@endsection
