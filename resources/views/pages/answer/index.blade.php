@extends('layouts.app')

@section('title')
    Opsi Jawaban
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('question.index') }}"
                class="bg-primary py-1 px-2 rounded-lg text-white hover:bg-secondary transition-all"><i
                    class="fa-solid fa-arrow-left-long"></i></a>
            <div class="text-xl font-semibold">Tambahkan Opsi Jawaban</div>
        </div>
        <div class="text-2xl font-semibold text-gray-600 mt-6">Pertanyaan : {{ $data->question }}</div>
        <div class="mt-6">
            <a href="{{ route('answer-create', $data->id) }}" class="px-6 py-3 bg-primary rounded-md text-white">
                Tambah Opsi Jawaban
            </a>
        </div>
        <div class="pt-4">
            <table id="answerTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                            Opsi Jawaban</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Pilihan</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $('#answerTable').DataTable({
                processing: true,
                ajax: "{{ route('answerData', ['question_id' => $data->id]) }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'answer',
                        name: 'answer'
                    },
                    {
                        data: 'is_correct',
                        name: 'is_correct',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="bg-green-500 text-white px-3 py-1 rounded-md">Benar</span>';
                            } else {
                                return '<span class="bg-red-500 text-white px-3 py-1 rounded-md">Salah</span>';
                            }
                        }
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            let editUrl = '{{ route('answer-edit', ':id') }}';
                            let deleteUrl = '{{ route('answer-destroy', ':id') }}';
                            editUrl = editUrl.replace(':id', data);
                            deleteUrl = deleteUrl.replace(':id', data);
                            return '<div class="flex">' +
                                '<a href="' + editUrl +
                                '" class="bg-yellow-500 px-3 text-sm py-1 rounded-md text-white mr-2" data-id="' +
                                data + '">Edit</a>' +
                                '<form action="' + deleteUrl +
                                '" method="POST" class="d-inline delete-form">' +
                                '@csrf' +
                                '@method('DELETE')' +
                                '<button class="bg-red-500 text-white px-3 text-sm py-1 rounded-md delete-button" type="button">Delete</button>' +
                                '</form>' +
                                '</div>';
                        }
                    },
                ]
            });

            // SweetAlert2 delete confirmation
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah kamu ingin menghapus Opsi Jawaban?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
