@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-3">
        <label>Email</label>
        <input name="email" value="{{ old('email') }}" required 
            class="form-control{{ $errors->has('email') ? ' is-invalid': '' }}">
        
        @if($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input name="password" value="" required 
            class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}">
        
        @if($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    
    </div>
    
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" 
            name="remember"
            value="{{ old('remember') ? 'checked':'' }}">
            <label class="form-check-label" for="remember">
                Remember Me    
            </label>   
            
        </div>
    </div>

    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </div>
</form>

@endsection