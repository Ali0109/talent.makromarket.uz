@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="info mb-3">
                <h4 class="text-center">@lang('main.name'): {{$user->name}}</h4>
                <h4 class="text-center">@lang('main.profession'): {{$user->profession}}</h4>
                <h5 class="text-center">@lang('main.description'): {{$talent->description}}</h5>
            </div>
            <div class="col-12 d-flex mb-5">
                @foreach($files as $file)
                    <div class="col-3">
                        <div class="card mx-3">
                            @if($file->src == 'upload/photo')
                                <img class="card-img-top" style="height: 180px; width: 290px"
                                     src="{{asset($file->src . '/' . $file->full_name)}}"
                                     alt="Card image cap">
                            @elseif($file->src == 'upload/video')
                                <video width="320" height="240" controls>
                                    <source src="{{asset($file->src . '/' . $file->full_name)}}"
                                            type="{{$file->mime_type}}">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($file->src == 'upload/audio')
                                <audio controls>
                                    <source src="{{asset($file->src . '/' . $file->full_name)}}"
                                            type="{{$file->mime_type}}">
                                    Your browser does not support the audio element.
                                </audio>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                @guest()
                    <form action="{{route('like_talent_cookie')}}" method="post">
                        @csrf
                        <input type="hidden" name="talent_id" value="{{$talent->id}}">
                        <button type="submit" class="btn btn-danger">
                            Like
                        </button>
                    </form>
                @else
                    <a href="{{route('auth.user.like_talent', ['talent_id' => $talent->id])}}" class="btn btn-danger">
                        Like
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
