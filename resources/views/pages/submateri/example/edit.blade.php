@extends('layouts.app')

@section('title')
    Edit Example
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('example-index', $data->sub_materi_id) }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Edit Example</div>
        </div>
        <div>
            <form action="{{ route('example-update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mt-6 flex flex-col gap-2">
                    <label for="">Nama Example</label>
                    <input type="text" placeholder="Masukkan Nama Example" name="name"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->name }}" required />
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <label for="">Deskripsi</label>
                    <textarea name="description" id="editor" cols="30" rows="10">{!! $data->description !!}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                        accept="audio/mpeg, audio/wav, video/mp4" onchange="previewAudio(event)">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Audio</label>
                        <div class="relative w-fit">
                            <audio id="audio-preview" controls class="{{ $data->audio ? '' : 'hidden' }}">
                                <source src="{{ $data->audio ? asset('storage/' . $data->audio) : '' }}" type="audio/mpeg">
                            </audio>
                            <span id="no-audio" class="{{ $data->audio ? 'hidden' : 'text-red-500' }}">Belum ada Audio</span>
                            <button type="button" id="delete-audio-button" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6 {{ $data->audio ? '' : 'hidden' }}" onclick="deleteAudio()">x</button>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="photo">Foto</label>
                        <input type="file" name="photo" class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImages(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <div class="relative w-1/3">
                            <div id="photo-preview" class="flex flex-wrap gap-2">
                                @if ($data->photo)
                                    <img src="{{ asset('storage/' . $data->photo) }}" class="w-full object-cover rounded-md" alt="Foto">
                                @endif
                            </div>
                            <span id="no-photo-text" class="{{ $data->photo ? 'hidden' : 'text-red-500' }}">Belum ada foto</span>
                            <button type="button" id="delete-photo-button" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6 {{ $data->photo ? '' : 'hidden' }}" onclick="deletePhoto()">x</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="delete_audio" id="deleted-audio">
                <input type="hidden" name="delete_photo" id="deleted-photo">
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Update Example</button>
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
            const deleteAudioButton = document.getElementById('delete-audio-button');

            const files = event.target.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    audioPreview.src = e.target.result;
                    audioPreview.classList.remove('hidden');
                    noAudioText.style.display = 'none';
                    deleteAudioButton.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                audioPreview.src = '';
                audioPreview.classList.add('hidden');
                noAudioText.style.display = 'block';
                deleteAudioButton.classList.add('hidden');
            }
        }

        function previewImages(event) {
            const photoPreview = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            const deletePhotoButton = document.getElementById('delete-photo-button');
            const files = event.target.files;
            photoPreview.innerHTML = '';

            if (files.length > 0) {
                noPhotoText.style.display = 'none';
                deletePhotoButton.classList.remove('hidden');
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-full', 'object-cover', 'rounded-md');
                        photoPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                noPhotoText.style.display = 'block';
                deletePhotoButton.classList.add('hidden');
            }
        }

        function deleteAudio() {
            const audio = document.getElementById('audio-preview');
            const deleteButton = document.getElementById('delete-audio-button');
            audio.src = '';
            audio.classList.add('hidden');
            deleteButton.classList.add('hidden');
            document.getElementById('no-audio').style.display = 'block';
            document.getElementById('deleted-audio').value = 'true';
        }

        function deletePhoto() {
            const photoPreview = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            const deleteButton = document.getElementById('delete-photo-button');
            photoPreview.innerHTML = '';
            noPhotoText.style.display = 'block';
            deleteButton.classList.add('hidden');
            document.getElementById('deleted-photo').value = 'true';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const audioPreview = document.getElementById('audio-preview');
            const noAudioText = document.getElementById('no-audio');
            const deleteAudioButton = document.getElementById('delete-audio-button');
            if (audioPreview.src) {
                audioPreview.classList.remove('hidden');
                noAudioText.style.display = 'none';
                deleteAudioButton.classList.remove('hidden');
            }

            const photoPreview = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            const deletePhotoButton = document.getElementById('delete-photo-button');
            if (photoPreview.querySelector('img')) {
                noPhotoText.style.display = 'none';
                deletePhotoButton.classList.remove('hidden');
            }
        });
    </script>
@endpush
