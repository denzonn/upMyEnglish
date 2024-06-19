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
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                        accept="audio/mpeg, video/mp4" onchange="previewAudio(event)">
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
                        <input type="file" name="photo[]" class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImages(event)" accept=".jpg, .jpeg, .png" multiple>
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <div id="photo-preview" class="flex flex-wrap gap-2"></div>
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

        function previewImages(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('photo-preview');
            previewContainer.innerHTML = ''; // Clear the preview container
            document.getElementById('no-photo-text').style.display = 'none';

            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.className = 'w-1/3 border-none';
                    previewContainer.appendChild(imgElement);
                };
                reader.readAsDataURL(file);
            }
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
