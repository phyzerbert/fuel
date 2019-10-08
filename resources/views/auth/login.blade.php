@extends('layouts.auth')

@section('content')    
    <div class="panel p-5" style="min-width:350px;">
        <div class="panel-header text-center mb-3">
            <h3 class="fs-30">Sign In</h3>
        </div>
        <hr>
        <div class="divider font-weight-bold text-uppercase text-dark d-table text-center my-3"></div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group mb-4">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Username" required autocomplete="name" autofocus>
                @error('name')
                    <div class="invalid-feedback text-left" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox mb-4 text-left">
                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-success btn-block">Sign In</button>
        </form>        
        <div class="bottom-text text-center my-3">
            Don't have an account? <a href="{{route('register')}}" class="font-weight-500">Sign Up</a><br>
        </div>
    </div>
@endsection
