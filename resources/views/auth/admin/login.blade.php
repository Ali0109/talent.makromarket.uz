@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <form action="{{route('admin.login_post')}}" method="POST" class="mb-5">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Введите email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                               placeholder="Email" value="{{old('email')}}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Введите пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                               placeholder="Пароль">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('phone').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '');
        });
    </script>
@endsection
