@extends('master')

@section('content')
    <body>
    <div class="background">
        <div class="container">
            <div class="fs-m"></div>
            <div>
                <img src="{{ asset('media/digidate.png') }}" class="img-center" height="200" alt="DORB logo">
            </div>
            <div class="fs-s"></div>
            <form action="{{ route('confirm-otp') }}" method="POST">
                @csrf
                @method('GET')
                <div class="form-group">
                    <label for="exampleInputPassword1">One-time password</label>
                    <input type="text" class="form-control" name="code" id="exampleInputPassword1" placeholder="Password">
                    <small id="emailHelp" class="form-text text-muted">
                        To ensure our security again spam accounts, you will have to verify that your email is legit.
                    </small>
                </div>
                <div class="fs-xs"></div>
                <button type="submit" class="btn bnt-lg btn-block btn-primary">Verify</button>
            </form>
        </div>
        <div class="fs-xl"></div>
    </div>
    </body>
@endsection
