@extends('backend.layouts.app')

@section('title', 'Roles')

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
                                        'label' => 'Tambah Roles',
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

                                            <th>{{ __('Name') }}</th>


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
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
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
    <script>
        var SIDEBAR_MINI = false;
        $(function() {
            if (window.innerWidth <= 425) {
                $('.btn-save-form').addClass('btn-block');
                $('.btn-reset-form').addClass('btn-block');
            }
        });

        function deleteGlobal(e, action_url) {
            e.preventDefault();
            swal({
                    title: 'Anda yakin?',
                    text: 'Sekali dihapus, data tidak akan kembali lagi!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        cancel: {
                            text: "Batal",
                            value: null,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Lanjutkan",
                        }
                    }
                })
                .then(function(willDelete) {
                    if (willDelete) {
                        $('#formDeleteGlobal').attr('action', action_url);
                        document.getElementById('formDeleteGlobal').submit();
                    } else {
                        swal('Info', 'Okay, tidak jadi', 'info');
                    }
                });
        }
    </script>
@endpush
