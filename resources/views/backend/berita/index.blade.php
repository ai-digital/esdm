@extends('backend.layouts.app')

@section('title', 'Berita')

@push('style')
    <link rel="stylesheet" href="{{ asset('stisla/library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endpush

@section('content')
    @include('sweetalert::alert')
    @include('backend.includes.breadcrumbs.breadcrumb-table')

    <div class="section-body">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
        <div class="row">
            <div class="col-12">
                @if ($data->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="{{ $icon }}"></i> Data {{ $title }}</h4>

                            <div class="card-header-action">

                                @if ($canCreate)
                                    @include('backend.includes.forms.buttons.btn-add', [
                                        'link' => $routeCreate,
                                    ])
                                @endif
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table-striped table yajra-datatable" id="table-1">

                                    <thead>
                                        <tr>

                                            <th>{{ __('No') }}</th>

                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Judul') }}</th>
                                            <th>{{ __('Gambar') }}</th>
                                            <th>{{ __('Tags') }}</th>
                                            <th>{{ __('Kategori') }}</th>

                                            <th>{{ __('Created At') }}</th>

                                            @if ($canUpdate || $canDelete || $canDetail)
                                                <th>{{ __('Aksi') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    @include('backend.includes.others.empty-state', [
                        'title' => 'Data ' . $title,
                        'icon' => $icon,
                        'link' => $routeCreate,
                    ])
                @endif
            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <!-- Page Specific JS File -->

    <script src="{{ asset('stisla/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('stisla/library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <script>
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('berita.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },



                    {
                        data: 'tags',
                        name: 'tags'
                    },

                    {
                        data: 'kategori_id',
                        name: 'kategori_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,

                    },
                ]
            });

        });
    </script>
    <script src="{{ asset('stisla/library/sweetalert/dist/sweetalert.min.js') }}"></script>


    <script src="{{ asset('stisla/js/page/modules-sweetalert.js') }}"></script>
@endpush
