@extends('master')

@section('content')
    <div class="buttons">

        <form action="{{ route('matchmaking.decline') }}" method="POST" id="pass">
            @method('POST')
            @csrf
            @if($user != null)
                <input type="hidden" value="{{ $user->id }}" name="user">
            @endif
            <button class="button-l btn btn-lg btn-danger" onClick="btnCooldown()" @if($user != null) id="myButton" @else disabled @endif>Pass</button>
        </form>

        <form action="{{ route('matchmaking.like') }}" method="POST" id="smash">
            @method('POST')
            @csrf
            @if($user != null)
                <input type="hidden" value="{{ $user->id }}" name="user">
            @endif
            <button type="submit" class="button-r btn btn-lg btn-success" onClick="btnCooldown()" @if($user != null) id="myButton2" @else disabled @endif>Smash</button>
        </form>
    </div>
    <div class="background">
        <div class="container" id="move" data-aos="zoom-in" data-aos-duration="500">
            @if($user == null)
                <div class="fs-l"></div>
                <div class="fs-s"></div>
                <h2 class="text-center">There are no persons to be shown.</h2>
                <div class="fs-l"></div>
            @else
                <div class="fs-s"></div>
                <div class="row">
                    <div class="col-sm">
                        <div class="card-container">
                            @if($user->is_enterprise == 1)
                                <span class="pro-2">ENTERPRISE</span>
                            @else
                            @endif

                                <img class="round profile mx-auto"

                                     src="{{ asset('storage/media/' .$user->username . '/profilePicture/' . $images[0]['image']) }}"
                                     alt="user">
                            <h3>{{ $user->username }}</h3>
                            <h6>{{ $user->address }}, {{ $user->country }}</h6>
                            <p>{{ $user->description }}</p>
                            <div class="buttons">
                                <div class="button">
                                    <form action="{{ route('matchmaking.index') }}" method="GET">
                                        @method('GET')
                                        @csrf
                                        <input type="hidden" name="prev_id" value="{{ $user->id }}">
                                        <button class="primary ghost">Back</button>
                                    </form>
                                </div>
                            </div>
                            <div class="skills">
                                <h6>Tags</h6>
                                <ul>
                                    @foreach($other_tags as $tag)
                                        <li>{{ $tag }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">

                        <div class="gallery-container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="gallery mx-3">
                                        @if($images[0]->image_2 != null)
                                            <img class="card-2"  src="{{ asset('storage/media/' .$user->username . '/secondaryPictures/' .$images[0]->image_2) }}">
                                        @else
                                            <img class="card-2"  src="{{ asset('media/placeholder.jpg') }}">
                                        @endif

                                        @if($images[0]->image_3 != null)
                                            <img class="card-2"  src="{{ asset('storage/media/' .$user->username . '/secondaryPictures/' .$images[0]->image_3) }}">
                                        @else
                                           <img class="card-2"  src="{{ asset('media/placeholder.jpg') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="gallery mx-3">
                                        @if($images[0]->image_4 != null)
                                            <img class="card-2"  src="{{ asset('storage/media/' .$user->username . '/secondaryPictures/' .$images[0]->image_4) }}">
                                        @else
                                           <img class="card-2"  src="{{ asset('media/placeholder.jpg') }}">
                                        @endif

                                        @if($images[0]->image_5 != null)
                                            <img class="card-2"  src="{{ asset('storage/media/' .$user->username . '/secondaryPictures/' .$images[0]->image_5) }}">
                                        @else
                                           <img class="card-2"  src="{{ asset('media/placeholder.jpg') }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            <div class="fs-s"></div>
        </div>
    </div>
@endsection
