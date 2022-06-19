@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex">
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th class="col-4">#</th>
                        <th class="col-4">@lang('main.name')</th>
                        <th class="col-4">@lang('main.profession')</th>
                        <th class="col-4">@lang('main.action')</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($talents as $talent)
                        <tr>
                            <th>{{$talent->user->id}}</th>
                            <td>{{$talent->user->name}}</td>
                            <td>{{$talent->user->profession}}</td>
                            <td><a href="{{route('talents', ['user_id' => $talent->user->id])}}" class="btn btn-primary">@lang('main.button_more')</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
