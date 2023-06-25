<div class="breadcrumbs">
    <div class="container">
        @foreach ($breadcrumbs as $item)
            @isset($item['link'])
                <span class="parent"> <i class="fa fa-home"></i>
                    <a href="{{ $item['link'] }}">{{ $item['label'] }}</a>
                </span>
                <i class="fa fa-chevron-right"></i>
            @else
                <span class="child"> {{ $item['label'] }}</span>
            @endisset
        @endforeach
    </div>

</div>
