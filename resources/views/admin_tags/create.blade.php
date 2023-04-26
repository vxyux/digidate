@extends('master')

@section('content')

    <body>
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <div>
                <h1>Create a new tag</h1>
                <h4>What's the tag name going to be?</h4>
            </div>
            <div class="fs-s"></div>
            <form action="{{ route('admin_tags.store') }}" method="POST">
                @csrf
                @method('POST')


                <div class="form-group">
                    <label for="exampleInputEmail1">Tag name<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="tagname" placeholder="Ex. Sport" value="{{ old('username') }}">
                </div>

                <div class="fs-s"></div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
        <div class="fs-xl"></div>
    </div>
    </body>
@endsection
