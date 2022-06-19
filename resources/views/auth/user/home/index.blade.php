@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center">@lang('home.user.hello') {{$user->name}}</h2>
            <div class="col-md-6">
                <form action="{{route('auth.user.file_store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="file">@lang('home.file.file')</label>
                        <input type="file" class="form-control-file @error('file') is-invalid @enderror"
                               id="file" name="file[]" multiple>
                        @error('file.*')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">@lang('home.file.file_description')</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" id="description" rows="3"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">@lang('home.file.upload')</button>
                </form>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{session('error')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
