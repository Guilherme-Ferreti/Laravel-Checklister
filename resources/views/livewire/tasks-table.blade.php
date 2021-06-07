<div>
    <table class="table table-responsive-sm" wire:sortable="updateTaskOrder">
        <tbody>
            @foreach ($tasks as $task)
                <tr wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}">
                    <td>{{ $task->name }}</td>
                    <td>
                        <a href="{{ route('admin.checklists.tasks.edit', [$checklist, $task]) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.checklists.tasks.destroy', [$checklist, $task]) }}" method="post" style="display:inline-block">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit"
                                onclick="return confirm('{{ __('Are you sure?')}}')"
                            >{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
