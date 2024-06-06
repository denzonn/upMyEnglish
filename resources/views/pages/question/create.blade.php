@extends('layouts.app')

@section('title')
    Buat SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('question.index') }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Tambahkan Pertanyaan</div>
        </div>
        <div>
            <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Pertanyaan</label>
                        <input type="text" placeholder="Masukkan Pertanyaan" name="question"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="sub_materi_id">Materi</label>
                        <select name="sub_materi_id" id="sub_materi_id"
                            class="bg-transparent border px-4 py-[8px] rounded-md">
                            @foreach ($submateri as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Bobot Pertanyaan</label>
                        <input type="number" placeholder="Masukkan Bobot Pertanyaan" name="bobot"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                            accept="audio/mpeg" onchange="previewAudio(event)">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Audio</label>
                        <audio id="audio-preview" controls class="hidden p-0"></audio>
                        <span id="no-audio" class="text-red-500">Belum ada Audio</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="photo">Foto</label>
                        <input type="file" name="photo" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                            onchange="previewImage(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <img id="photo-preview" class="w-1/3 border-none" src="">
                        <span id="no-photo-text" class="text-red-500">Belum ada foto</span>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Tambah Pertanyaan</button>
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
            reader.onload = function() {
                const output = document.getElementById('photo-preview');
                output.src = reader.result;
                document.getElementById('no-photo-text').style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewAudio(event) {
            const audio = document.getElementById('audio-preview');
            const file = event.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                audio.src = url;
                audio.classList.remove('hidden');
                document.getElementById('no-audio').style.display = 'none';
            } else {
                audio.classList.add('hidden');
            }
        }
    </script>
@endpush
