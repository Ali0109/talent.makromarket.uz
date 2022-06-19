@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($talents as $talent)
                    <div class="card bg-dark text-white mx-3 mb-3">
                        <div class="card-body mb-3 d-flex justify-content-center">
                            <div class="col-md-4 text-center">
                                Имя: {{$talent->user->name}}
                            </div>
                            <div class="col-md-4 text-center">
                                Роль: {{$talent->user->profession}}
                            </div>
                            <div class="col-md-4 text-center">
                                Лайки: {{$talent->likes_count}}
                            </div>
                        </div>
                        <div class="src_block mb-3 d-flex justify-content-around">
                            @foreach($talent->files as $file)
                                @if($file->src == 'upload/photo')
                                    <img class="card-img-top d-inline" style="height: 180px; width: 290px"
                                         src="{{asset($file->src . '/' . $file->full_name)}}"
                                         alt="Card image cap">
                                @elseif($file->src == 'upload/video')
                                    <video width="320" height="240" controls>
                                        <source src="{{asset($file->src . '/' . $file->full_name)}}"
                                                type="{{$file->mime_type}}" class="d-inline">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($file->src == 'upload/audio')
                                    <audio controls>
                                        <source src="{{asset($file->src . '/' . $file->full_name)}}"
                                                type="{{$file->mime_type}}" class="d-inline">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
