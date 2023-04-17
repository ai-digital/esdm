@if ($canUpdate || $canDelete)
    <td>

        @if ($canUpdate)
            @include('backend.includes.forms.buttons.btn-edit', [
                'link' => route('roles.edit', [$item->id]),
            ])
        @endif
        @if ($canDelete)
            @include('backend.includes.forms.buttons.btn-delete', [
                'link' => route('roles.destroy', [$item->id]),
            ])
        @endif

    </td>
@endif
