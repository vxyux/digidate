@extends('master')

@section('content')
    <body>
        <div class="background">
            <div class="container">
                <div class="fs-s"></div>
                <div >
                    <img src="{{ asset('media/digidate.png') }}" class="img-center" height="200" alt="DORB logo">
                </div>
                <div class="fs-s"></div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    @method('POST')
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp" autofocus placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                        </div>
                    <div class="fs-xs"></div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="fs-xl"></div>
        </div>
    </body>
@endsection
