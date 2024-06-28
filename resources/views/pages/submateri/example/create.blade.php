@extends('layouts.app')

@section('title')
    Buat Example
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('example-index', $data->id) }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Buat Example</div>
        </div>
        <div>
            <form action="{{ route('example-store', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-6 flex flex-col gap-2">
                    <label for="">Nama Example</label>
                    <input type="text" placeholder="Masukkan Nama Example" name="name"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" required />
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <label for="">Deskripsi</label>
                    <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                        accept="audio/mpeg, audio/wav, video/mp4" onchange="previewAudio(event)">
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
                        <input type="file" name="photo" class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImages(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <div id="photo-preview" class="flex flex-wrap gap-2"></div>
                        <span id="no-photo-text" class="text-red-500">Belum ada foto</span>
                    </div>
                </div>
                <input type="hidden" value="{{ $data->id }}" name="sub_materi_id">
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Buat Example</button>
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

        function previewAudio(event) {
            const audioPreview = document.getElementById('audio-preview');
            const noAudioText = document.getElementById('no-audio');

            const files = event.target.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    audioPreview.src = e.target.result;
                    audioPreview.classList.remove('hidden');
                    noAudioText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                audioPreview.src = '';
                audioPreview.classList.add('hidden');
                noAudioText.classList.remove('hidden');
            }
        }

        function previewImages(event) {
            const photoPreview = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            const files = event.target.files;
            photoPreview.innerHTML = '';

            if (files.length > 0) {
                noPhotoText.classList.add('hidden');
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-1/3', 'object-cover', 'rounded-md');
                        photoPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                noPhotoText.classList.remove('hidden');
            }
        }
    </script>
@endpush
