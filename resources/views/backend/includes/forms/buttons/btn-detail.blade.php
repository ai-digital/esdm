@php
    $icon = $icon ?? 'fa fa-eye';
@endphp
<a class="btn btn-sm btn-success @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link }}"
    data-toggle="tooltip" title="{{ $label ?? __('Detail') }}">
    @if ($icon ?? false)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $label ?? false }}
</a>
