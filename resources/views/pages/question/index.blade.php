@extends('layouts.app')

@section('title')
    Pertanyaan
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <a href="{{ route('question.create') }}" class="px-6 py-3 bg-primary rounded-md text-white">
            Tambah Pertanyaan
        </a>
        <div class="pt-4">
            <table id="questionTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Nama SubMateri</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">
                            Pertanyaan</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            Bobot</th>
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
            $('#questionTable').DataTable({
                processing: true,
                ajax: "{{ route('questionData') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'submateri.name',
                        name: 'submateri.name'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'bobot',
                        name: 'bobot'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            let editUrl = '{{ route('question.edit', ':id') }}';
                            let deleteUrl = '{{ route('question.destroy', ':id') }}';
                            let answerUrl = '{{ route('answer-index', ':id') }}';
                            editUrl = editUrl.replace(':id', data);
                            deleteUrl = deleteUrl.replace(':id', data);
                            answerUrl = answerUrl.replace(':id', data);
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
                                '<a href="' + answerUrl +
                                '" class="bg-primary px-3 text-sm py-1 rounded-md text-white ml-2" data-id="' +
                                data + '">Opsi</a>' +
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
                    text: "Apakah kamu ingin menghapus Pertanyaan?",
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
