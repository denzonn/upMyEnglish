@extends('layouts.app')

@section('title')
    Edit SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('submateri.index') }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Edit SubMateri</div>
        </div>
        <div>
            <form action="{{ route('submateri.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="">Nama Sub Materi</label>
                        <input type="text" placeholder="Masukkan Nama Materi" name="name"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->name }}"
                            required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="">Materi</label>
                        <select name="materi_id" id="" class="bg-transparent border px-4 py-[8px] rounded-md">
                            @foreach ($materi as $item)
                                <option value="{{ $item->id }}" {{ $item->id === $data->materi_id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <label for="">Deskripsi</label>
                    <textarea name="description" id="editor" cols="30" rows="10">{!! $data->description !!}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                        accept="audio/mpeg, audio/wav, video/mp4"  onchange="previewAudio(event)">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Audio</label>
                        <div class="relative w-fit">
                            <audio id="audio-preview" controls class="{{ $data->audio ? '' : 'hidden' }} p-0">
                                <source src="{{ $data->audio ? asset('storage/' . $data->audio) : '' }}" type="audio/mpeg">
                            </audio>
                            <button type="button" id="delete-audio-button"
                                class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6 {{ $data->audio ? '' : 'hidden' }}"
                                onclick="deleteAudio()">x</button>
                        </div>
                        <span id="no-audio" class="{{ $data->audio ? 'hidden' : 'text-red-500' }}">Belum ada Audio</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="">Foto</label>
                        <input type="file" name="photo[]" class="w-full border px-4 py-2 rounded-md bg-transparent"
                            onchange="previewImages(event)" accept=".jpg, .jpeg, .png" multiple>
                    </div>
                    <div class="mt-6 flex flex-col gap-2 ">
                        <label>Pratinjau Foto</label>
                        <div id="photo-preview" class="flex flex-wrap gap-4">
                            @foreach ($photos as $photo)
                                <div class="relative w-1/3 existing-photo" data-photo-id="{{ $photo->id }}">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="w-full border-none" />
                                    <button type="button"
                                        class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6"
                                        onclick="deleteImage(this, true)">x</button>
                                    <input type="hidden" name="existing_photos[]" value="{{ $photo->photo }}">
                                </div>
                            @endforeach
                        </div>
                        <span id="no-photo-text" class="{{ $photos->isEmpty() ? 'text-red-500' : 'hidden' }}">Belum ada
                            foto</span>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Update SubMateri</button>
                </div>
                <input type="hidden" name="deleted_photos" id="deleted-photos">
                <input type="hidden" name="deleted_audio" id="deleted-audio">
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

        let existingPhotoIds = [];

        function previewImages(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            noPhotoText.classList.add('hidden');

            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const divElement = document.createElement('div');
                    divElement.className = 'relative w-1/3';

                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.className = 'w-full border-none';

                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className =
                        'absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6';
                    deleteButton.innerText = 'x';
                    deleteButton.onclick = function() {
                        divElement.remove();
                        updatePhotoPreview();
                    };

                    divElement.appendChild(imgElement);
                    divElement.appendChild(deleteButton);
                    previewContainer.appendChild(divElement);
                };
                reader.readAsDataURL(file);
            }
        }

        function deleteImage(button, isExisting = false) {
            const parent = button.parentElement;
            if (isExisting) {
                const photoId = parent.getAttribute('data-photo-id');
                existingPhotoIds.push(photoId);
            }
            parent.remove();
            updatePhotoPreview();
        }

        function updatePhotoPreview() {
            const previewContainer = document.getElementById('photo-preview');
            const noPhotoText = document.getElementById('no-photo-text');
            if (previewContainer.children.length === 0) {
                noPhotoText.classList.remove('hidden');
            } else {
                noPhotoText.classList.add('hidden');
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
                document.getElementById('delete-audio-button').classList.remove('hidden');
            } else {
                audio.classList.add('hidden');
                document.getElementById('delete-audio-button').classList.add('hidden');
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

        document.querySelector('form').addEventListener('submit', function(event) {
            const deletedPhotosInput = document.getElementById('deleted-photos');
            deletedPhotosInput.value = JSON.stringify(existingPhotoIds);
        });
    </script>
@endpush
