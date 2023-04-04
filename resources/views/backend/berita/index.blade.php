@extends('backend.layouts.app')

@section('title', 'Berita')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    @include('backend.includes.breadcrumbs.breadcrumb-table')

    <div class="section-body">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
        <div class="row">
            <div class="col-12">
                @if ($data->count() > 0 || $isYajra)

                    <div class="card">
                        <div class="card-header">
                            <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>

                            <div class="card-header-action">

                                @if ($canCreate)
                                    @include('stisla.includes.forms.buttons.btn-add', [
                                        'link' => $route_create,
                                    ])
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @include('backend.includes.forms.buttons.btn-datatable')
                            <div class="table-responsive">
                                @include('backend.berita.table')
                            </div>
                        </div>
                    </div>
                @else
                    @include('backend.includes.others.empty-state', [
                        'title' => 'Data ' . $title,
                        'icon' => $moduleIcon,
                        'link' => $route_create,
                    ])
                @endif
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <!-- Page Specific JS File -->
    <script>
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('berita.ajax') }}",
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
                        data: 'kategori',
                        name: 'kategori'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
    @endif
@endpush
