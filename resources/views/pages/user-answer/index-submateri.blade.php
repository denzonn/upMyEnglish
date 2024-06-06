@extends('layouts.app')

@section('title')
Jawaban User
@endsection

@section('content')
    <div class="bg-white p-8 rounded-md text-gray-500">
        <div class="pt-4">
            <table id="materiTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                            Materi</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                            Sub Materi</th>
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
            $('#materiTable').DataTable({
                processing: true,
                ajax: "{{ route('user-answer.submateri-data', $user->id) }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'sub_materi.materi.name',
                        name: 'sub_materi.materi.name'
                    },
                    {
                        data: 'sub_materi.name',
                        name: 'sub_materi.name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            let detailUrl = '{{ route('user-answer-detail', ':id') }}';
                            detailUrl = detailUrl.replace(':id', data);
                            return '<div class="flex">' +
                                '<a href="' + detailUrl +
                                '" class="bg-yellow-500 px-3 text-sm py-1 rounded-md text-white mr-2" data-id="' +
                                data + '">Detail Jawaban</a>'
                                '</div>';
                        }
                    },
                ]
            });
        });
    </script>
@endpush
