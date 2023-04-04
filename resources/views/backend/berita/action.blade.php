@if ($canUpdate || $canDelete || $canDetail)
    <td>
        @if ($canUpdate)
            @include('backend.includes.forms.buttons.btn-edit', [
                'link' => route('berita.edit', [$item->id]),
            ])
        @endif
        @if ($canDelete)
            @include('backend.includes.forms.buttons.btn-delete', [
                'link' => route('berita.destroy', [$item->id]),
            ])
        @endif
        @if ($canDetail)
            @include('backend.includes.forms.buttons.btn-detail', [
                'link' => route('berita.show', [$item->id]),
            ])
        @endif
    </td>
@endif
