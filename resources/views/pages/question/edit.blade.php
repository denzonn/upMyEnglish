@extends('layouts.app')

@section('title')
    Edit SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('question.index') }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Edit Pertanyaan</div>
        </div>
        <div>
            <form action="{{ route('question.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Pertanyaan</label>
                        <input type="text" placeholder="Masukkan Pertanyaan" name="question"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->question }}"
                            required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="sub_materi_id">Materi</label>
                        <select name="sub_materi_id" id="sub_materi_id"
                            class="bg-transparent border px-4 py-[8px] rounded-md">
                            @foreach ($submateri as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id === $data->sub_materi_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="name">Bobot Pertanyaan</label>
                        <input type="number" placeholder="Masukkan Bobot Pertanyaan" name="bobot"
                            class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->bobot }}"
                            required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="audio">Audio</label>
                        <input type="file" name="audio" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                        accept="audio/mpeg, audio/wav, video/mp4" onchange="previewAudio(event)">
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
                        <label for="photo">Foto</label>
                        <input type="file" name="photo" class="w-full border px-4 py-[6px] rounded-md bg-transparent"
                            onchange="previewImage(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <div class="relative flex w-1/3">
                            @if ($data->photo !== null)
                                <img id="photo-preview" class="border-none" src="{{ asset('storage/' . $data->photo) }}">
                                <button id="delete-button" type="button" onclick="deleteExistingPhoto()"
                                    class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full flex justify-center items-center w-6 h-6">x</button>
                            @endif
                            <input type="hidden" name="existing_photos[]" value="{{ $data->photo }}">
                        </div>
                        <span id="no-photo-text" class="{{ $data->photo ? 'hidden' : 'text-red-500' }}">Belum ada
                            foto</span>
                    </div>
                </div>
                <input type="hidden" name="deleted_audio" id="deleted-audio">
                <div class="mt-6 flex flex-col gap-2 justify-end">
                    <button type="submit" class="rounded-md bg-primary text-white py-2 text-lg">Update Pertanyaan</button>
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

        function deleteExistingPhoto() {
            const photoPreview = document.getElementById('photo-preview');
            const deleteButton = document.getElementById('delete-button');
            const noPhotoText = document.getElementById('no-photo-text');
            const existingPhotoInput = document.querySelector('input[name="existing_photos[]"]');

            photoPreview.src = '';
            noPhotoText.classList.remove('hidden');
            deleteButton.classList.add('hidden');
            existingPhotoInput.parentNode.removeChild(existingPhotoInput);
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
            // Buat input hidden untuk menyimpan ID foto yang akan dihapus
            const deletedPhotosInput = document.createElement('input');
            deletedPhotosInput.type = 'hidden';
            deletedPhotosInput.name = 'deleted_photos';
            deletedPhotosInput.value = JSON.stringify(deletedPhotoIds); // Ubah ke JSON jika diperlukan
            this.appendChild(deletedPhotosInput);
        });
    </script>
@endpush
