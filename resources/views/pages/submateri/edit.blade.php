@extends('layouts.app')

@section('title')
    Edit SubMateri
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('submateri.index') }}" class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i class="fa-solid fa-arrow-left-long"></i></a>
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
                            class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->name }}" required />
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label for="">Materi</label>
                        <select name="materi_id" id="" class="bg-transparent border px-4 py-[8px] rounded-md">
                            @foreach ($materi as $item)
                                <option value="{{ $item->id }}" {{ $item->id === $data->materi_id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                        <label for="">Foto</label>
                        <input type="file" name="photo" class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImage(event)" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-6 flex flex-col gap-2">
                        <label>Pratinjau Foto</label>
                        <img id="photo-preview" src="{{ $data->photo ? asset('storage/' . $data->photo) : '' }}" class="w-1/3 border-none" />
                        <span id="no-photo-text" class="{{ $data->photo ? 'hidden' : 'text-red-500' }}">Belum ada foto</span>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-2 justify-end ">
                    <button type="submit" class=" rounded-md bg-primary text-white py-2 text-lg">Update
                        SubMateri</button>
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
    </script>

    <script>
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
