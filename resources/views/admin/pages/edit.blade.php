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


                    <form action="{{ route('admin.pages.update', $page) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-header"><strong>{{ __('Edit page') }}</strong></div>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}</label>
                                        <input value="{{ old('title', $page->title) }}" class="form-control" name="title" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">{{ __('Content') }}</label>
                                        <textarea class="form-control" name="content" id="page-textarea" rows="5">{{ old('content', $page->content) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save Page') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#page-textarea'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection