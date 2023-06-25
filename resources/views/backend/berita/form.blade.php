@extends('backend.layouts.app')

@section('title')
    {{ $fullTitle }}
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('stisla/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/library/datetime/flatpickr.min.css') }}">
@endpush
@section('content')
    @include('sweetalert::alert')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        @include('backend.includes.breadcrumbs.breadcrumb', [
            'breadcrumbs' => $breadcrumbs,
        ])
    </div>


    <div class="section-body">
        <h2 class="section-title">{{ $fullTitle }}</h2>
        <p class="section-lead">{{ __('Menampilkan halaman ' . $fullTitle) }}.</p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="{{ $moduleIcon }}"></i> {{ $fullTitle }}</h4>
                        <div class="card-header-action">
                            @include('backend.includes.forms.buttons.btn-view', [
                                'link' => route('berita.index'),
                            ])
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="formAction">

                            @isset($d)
                                @method('PUT')
                                {{-- @include('backend.includes.forms.inputs.input', [
                                    'required' => true,
                                    'name' => 'id',
                                    'label' => 'id',
                                    'readonly' => 'true',
                                ]) --}}
                            @endisset

                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @include('backend.includes.forms.inputs.input', [
                                        'required' => true,
                                        'name' => 'judul',
                                        'label' => 'Judul',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.forms.inputs.input', [
                                        'required' => true,
                                        'name' => 'tanggal',
                                        'type' => 'text',
                                        'label' => 'Tanggal',
                                        'addClass' => 'datetimepicker',
                                        'icon' => 'fa fa-calendar',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.forms.selects.select', [
                                        'id' => 'kategori_id',
                                        'name' => 'kategori_id',
                                        'options' => $kategories,
                                        'label' => 'Kategori',
                                        'required' => true,
                                    ])
                                </div>

                                <div class="col-md-12">
                                    @include('backend.includes.forms.editors.summernote', [
                                        'required' => true,
                                        'name' => 'isi_berita',
                                        'label' => 'Isi berita',
                                        'id' => 'isi_berita',
                                    ])
                                </div>

                                <div class="col-md-6">
                                    <div id="image-preview" class="image-preview">
                                        @include('backend.includes.forms.inputs.input', [
                                            'required' => isset($d) ? false : true,
                                            'name' => 'gambar',
                                            'type' => 'file',
                                            'label' => 'Gambar (rekomendasi ukuran 1024x768)',
                                            'id' => 'image-upload',
                                            'accept' => '.png, .jpg, .jpeg,.bmp, .gif,.tiff',
                                        ])

                                    </div>
                                    @isset($d)
                                        @include('backend.berita.gambar')
                                    @endisset
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.forms.inputs.input', [
                                        'name' => 'tags',
                                        'type' => 'text',
                                        'label' => 'Tags',
                                        'addClass' => 'inputtags',
                                        'placeholder' => ',',
                                    ])
                                </div>
                                <div class="col-md-12" id="formAreaButton">
                                    <br>
                                    @include('backend.includes.forms.buttons.btn-save')
                                    @include('backend.includes.forms.buttons.btn-reset')
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('stisla/library/upload-preview/upload-preview.js') }}"></script>
    <script src="{{ asset('stisla/library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('stisla/library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('stisla/library/datetime/flatpickr.js') }}"></script>

    <script>
        var dateNow = new Date();
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
        "use strict";

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $(".inputtags").tagsinput('items');
    </script>
    @include('backend.includes.scripts.disable-form')
@endpush
