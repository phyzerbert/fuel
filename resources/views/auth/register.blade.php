@extends('layouts.auth')

@section('content')
        
    <div class="panel p-5" style="min-width:350px;">
        <div class="panel-header text-center mb-3">
            <h3 class="fs-30">Sign Up</h3>
        </div>
        <hr>
        <div class="divider font-weight-bold text-uppercase text-dark d-table text-center my-3"></div>
        <form method="POST" action="{{ route('register') }}">
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
                @php
                    $units = \App\Models\Unit::all();
                @endphp
                <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" required>
                    <option value="" hidden>Unit</option>
                    @foreach ($units as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>                        
                    @endforeach
                </select>
                @error('unit')
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
            <div class="form-group mb-5">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-success btn-block">Sign Up</button>
        </form>        
        <div class="bottom-text text-center my-3">
            Don't have an account? <a href="{{route('login')}}" class="font-weight-500">Sign In</a><br>
        </div>
    </div>
@endsection
