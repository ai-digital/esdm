@extends('backend.layouts.app')

@section('title')
    {{ $fullTitle }}
@endsection

@section('content')
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
                                @include('backend.includes.forms.inputs.input', [
                                    'required' => true,
                                    'name' => 'id',
                                    'label' => 'id',
                                    'readonly' => 'true',
                                ])
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
                                        'type' => 'date',
                                        'label' => 'Tanggal',
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
                                        'name' => 'isi',
                                        'label' => 'isi',
                                        'id' => 'isi',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.forms.inputs.input', [
                                        'required' => true,
                                        'name' => 'tags',
                                        'type' => 'text',
                                        'label' => 'Tags',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.forms.inputs.input', [
                                        'required' => isset($d) ? false : true,
                                        'name' => 'gambar',
                                        'type' => 'file',
                                        'label' => 'File',
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
    <script src="{{ asset('stisla/library/summernote/dist/summernote-bs4.js') }}"></script>
    @include('backend.includes.scripts.disable-form')
@endpush
