@extends('layouts.base')
@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}" media="all">
@endsection

@section('content')

    <main>
        <section class="container {{ $errors->has('email') ? ' error' : '' }}" id="login">
            <div class="login__title">
                <h3>Login</h3>
            </div>

            <form class="form-login" id="form-login" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="row">
                    <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}"
                           placeholder="Correo Electrónico" required autofocus>

                </div>

                <div class="row">
                    <input id="password" type="password" class="validate" name="password" placeholder="Contraseña"
                           required>
                </div>

                <input class="btn-login" type="submit" value="Log In"/>

                @if ($errors->has('email'))
                    <span class="info-box">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                @endif

                @if ($errors->has('password'))
                    <span class="info-box">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
                @endif


            </form>

        </section>

        @section('js')
            <script>
              var url = "{{  url('/')}}";
            </script>
            <script src="{{asset('js/login.js')}}"></script>
        @endsection

    </main>

@endsection
