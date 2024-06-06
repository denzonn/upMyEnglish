@extends('layouts.app')

@section('title')
    Buat SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('submateri.index') }}" class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Tambahkan SubMateri</div>
        </div>
        <div>
            <form action="{{ route('submateri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Nama Sub Materi</label>
                        <input type="text" placeholder="Masukkan Nama Materi" name="name"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="materi_id">Materi</label>
                        <select name="materi_id" id="materi_id" class="bg-transparent border px-4 py-[8px] rounded-md">
                            @foreach ($materi as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="photo">Foto</label>
                        <input type="file" name="photo" class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImage(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <img id="photo-preview" class="w-1/3 border-none" src="">
                        <span id="no-photo-text" class="text-red-500">Belum ada foto</span>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Tambah SubMateri</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('photo-preview');
                output.src = reader.result;
                document.getElementById('no-photo-text').style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
