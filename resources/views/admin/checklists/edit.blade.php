@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.checklist_groups.checklists.update', [$checklistGroup, $checklist]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-header"><strong>{{ __('Edit checklist') }}</strong></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input value="{{ $checklist->name }}" class="form-control" name="name" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save Checklist') }}</button>
                        </div>
                    </form>
                </div>
                <form action="{{ route('admin.checklist_groups.checklists.destroy', [$checklistGroup, $checklist]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" type="submit"
                        onclick="return confirm('{{ __('Are you sure?')}}')"
                    >{{ __('Delete This Checklist') }}</button>
                </form>

                <hr />

                <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>{{ __('List of Tasks') }}</div>
                        <div class="card-body">
                        <table class="table table-responsive-sm">
                            <tbody>
                                @foreach ($checklist->tasks as $task)
                                    <tr>
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
                </div>

                @if ($errors->storetask->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->storetask->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <form action="{{ route('admin.checklists.tasks.store', [$checklist]) }}" method="post">
                        @csrf
                        <div class="card-header"><strong>{{ __('New task') }}</strong></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input value="{{ old('name') }}" class="form-control" name="name" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea class="form-control" name="description" rows="5">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save Task') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection