@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}" media="all">
@endsection

@section('content')

<main>
    <section class="container {{ $errors->has('email') ? ' error' : '' }}" id="login">
        <div class="login__title">
            <h3>Reset Password</h3>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-login" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="row">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required autofocus>
            </div>

            <button type="submit" class="btn btn-login">
                Enviar link de reseteo de Password
            </button>

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

</main>

@endsection
