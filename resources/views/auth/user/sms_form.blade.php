@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-6">
                <form action="{{route('sms_check_post')}}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="sms">@lang('auth.sms_form.sms'):</label>
                        <input type="text" class="form-control @error('sms') is-invalid @enderror"
                               id="sms" name="sms" maxlength="6"
                               placeholder="@lang('auth.sms_form.sms_code_description')">
                        <input type="hidden" name="id" value="{{$id}}">
                        @error('sms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">@lang('auth.button')</button>
                </form>
                @if(session('error'))
                    <div class="text-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.querySelector('#sms').addEventListener('input',
            function (e) {
                this.value = this.value.replace(/[^\d]/g, '');
            }
        );
    </script>
@endsection
