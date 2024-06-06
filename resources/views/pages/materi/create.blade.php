@extends('layouts.app')

@section('title')
    Buat Materi
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('materi.index') }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Tambahkan Materi</div>
        </div>
        <div>
            <form action="{{ route('materi.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="">Nama Materi</label>
                        <input type="text" placeholder="Masukkan Nama Materi" name="name"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2 justify-end ">
                        <button type="submit" class=" rounded-md bg-primary text-white py-2 text-lg">Tambah
                            Materi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
