@if (Str::contains($gambar, 'http'))
    <a class="btn btn-info btn-sm" href="{{ $gambar }}" target="_blank">Lihat</a>
@elseif($gambar)
    <a class="btn btn-info btn-sm" href="{{ url($gambar) }}" target="_blank">Lihat</a>
@else
    -
@endif
