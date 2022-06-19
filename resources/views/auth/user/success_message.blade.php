@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{session('success')}}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger text-center">
                        {{session('error')}}
                    </div>
                @else
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">@lang('home.file.come_back')</button>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
