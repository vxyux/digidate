@extends('master')

@section('content')

    <body>
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <div>
                <h1>Edit a new pickup line</h1>
                <h4>What's the line going to be?</h4>
            </div>
            <div class="fs-s"></div>
            @foreach($crud as $cruds)
                <form action="{{ route('admin_sentences.update', $cruds->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @php
                        $line = str_replace("{{ user->first_name }}", "(name)", $cruds->content);
                    @endphp
                    <div class="form-group">
                        <label for="exampleInputEmail1">Enter the line<span class="text-red">*</span></label>
                        <input type="text" class="form-control" name="pickupline" placeholder="Ex. Wagwan G"
                               value="{{ $line }}">
                    </div>
                    <b class="">Psst.. if you enter (name) the firstname of that person wil be entered </b>
                    <div class="fs-s"></div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

                </form>
            @endforeach
        </div>
        <div class="fs-xl"></div>
    </div>
    </body>
@endsection
