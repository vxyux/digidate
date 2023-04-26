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
            <form action="{{ route('register') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="exampleInputEmail1">Username<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="username" placeholder="JoeBidenWakeUp12" value="{{ old('username') }}">
                    <small id="emailHelp" class="form-text text-muted">You will need the username to log in to your account.</small>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First name<span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="first_name" aria-describedby="emailHelp"  value="{{ old('first_name') }}">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Infix</label>
                            <input type="text" class="form-control" name="infix" aria-describedby="emailHelp" value="{{ old('infix') }}">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last name<span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="last_name" aria-describedby="emailHelp" value="{{ old('last_name') }}" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Date of birth<span class="text-red">*</span></label>
                    <input type="date" class="form-control" name="dob" aria-describedby="emailHelp" placeholder="Janssen" value="{{ old('dob') }}">
                    <small id="emailHelp" class="form-text text-muted">You need to be atleast 18 years old to register to <b>DigiDate</b>.</small>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Home address<span class="text-red">*</span></label>
                            <input type="text" value="{{ old('address') }}" class="form-control" id="exampleInputEmail1" name="address" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Street number<span class="text-red">*</span></label>
                            <input type="text" value="{{ old('street_nr') }}" class="form-control" id="exampleInputEmail1" name="street_nr" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Country<span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="country" placeholder="Netherlands" value="{{ old('country') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">City name<span class="text-red">*</span></label>
                            <input type="text" value="{{ old('city') }}" class="form-control" id="exampleInputEmail1" name="city" aria-describedby="emailHelp" placeholder="Arnhem"  >
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Zipcode<span class="text-red">*</span></label>
                            <input type="text" value="{{ old('zipcode') }}" class="form-control" id="exampleInputEmail1" name="zipcode" aria-describedby="emailHelp" placeholder="1234AB"  >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address<span class="text-red">*</span></label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{ old('email') }}" placeholder="Email address">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone number</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" name="number" placeholder="12 34567890">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password<span class="text-red">*</span></label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                    <small id="emailHelp" class="form-text text-muted">The password has to at least be 8 characters long, 1 capital letter, and 1 number.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Repeat password<span class="text-red">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword2" placeholder="Repeated password">
                </div>
                <div class="fs-s"></div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
        <div class="fs-xl"></div>
    </div>
    </body>
@endsection
