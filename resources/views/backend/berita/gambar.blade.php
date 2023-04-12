@if (Str::contains($gambar, 'http'))
    <a class="btn btn-primary btn-sm" href="{{ $gambar }}" target="_blank">Lihat</a>
@elseif($gambar)
    <a class="btn btn-success btn-sm" href="{{ url($gambar) }}" target="_blank">Lihat</a>
@else
    -
@endif
