@extends('backend.layouts.app')

@section('title')
    {{ $fullTitle }}
@endsection

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
                                'link' => route('kategori.index'),
                            ])
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ $action }}" method="POST" id="formAction">

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
                                        'name' => 'kategori',
                                        'label' => 'Kategori',
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
    @include('backend.includes.scripts.disable-form')
@endpush
