@if ($canUpdate || $canDelete || $canDetail)
    <td>

        @if ($canUpdate)
            @include('backend.includes.forms.buttons.btn-edit', [
                'link' => route('kategori.edit', [$item->id]),
            ])
        @endif
        @if ($canDelete)
            @include('backend.includes.forms.buttons.btn-delete', [
                'link' => route('kategori.destroy', [$item->id]),
            ])
        @endif

    </td>
@endif
