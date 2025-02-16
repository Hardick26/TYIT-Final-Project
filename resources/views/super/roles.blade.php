<td>
    <div class="d-flex gap-2">
        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-link p-0">
            <i class="align-middle" data-feather="eye"></i>
        </a>
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-link p-0">
            <i class="align-middle" data-feather="edit-2"></i>
        </a>
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this role?')">
                <i class="align-middle" data-feather="trash-2"></i>
            </button>
        </form>
    </div>
</td> 