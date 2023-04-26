@extends('master')

@section('content')
    <div class="buttons">
    <form action="{{ route('matchmaking.decline') }}" method="POST" id="pass">
        @method('POST')
        @csrf
        @if($user != null)
            <input type="hidden" value="{{ $user->u1 }}" name="user">
        @endif
        <button class="button-l btn btn-lg btn-danger" onClick="btnCooldown()" @if($user != null) id="myButton"
                @else disabled @endif>Pass
        </button>
    </form>

        <form action="{{ route('matchmaking.like') }}" method="POST" id="smash">
            @method('POST')
            @csrf
            @if($user != null)
                <input type="hidden" value="{{ $user->u1 }}" name="user">
            @endif
            <button type="submit" class="button-r btn btn-lg btn-success" onClick="btnCooldown()"
                    @if($user != null) id="myButton2" @else disabled @endif>Smash
            </button>
        </form>
    </div>

    <div class="background">
        <div class="container">

            <ul class="filter">
                <br>
                <form action="{{ route('matchmaking.index') }}" method="GET">
                    @method('GET')
                    @csrf

                    <select class="form-control" id="filter" name="filter" onchange="this.form.submit()">
                        <option value="0" @if ($chosen == 0) selected @endif>None</option>
                        <option value="1" @if ($chosen == 1) selected @endif>1 tag</option>
                        <option value="2" @if ($chosen == 2) selected @endif>2 tags</option>
                        <option value="3" @if ($chosen == 3) selected @endif>3 tags</option>
                        <option value="4" @if ($chosen == 4) selected @endif>4 tags</option>
                        <option value="5" @if ($chosen == 5) selected @endif>All tags</option>
                    </select>
                </form>

                <li>
                    <desc>Your tags:</desc>
                </li>
                @foreach($tags as $tag)
                    <li>
                        <tag><b>{{ $tag }}</b></tag>
                    </li>
                @endforeach
            </ul>

        </div>
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
                                <span class="pro">ENTERPRISE</span>
                            @else
                            @endif
{{--                            @dd($user)--}}
                            <img class="round profile mx-auto"

                                 src="{{ asset('storage/media/' .$user->username . '/profilePicture/' . $user->image) }}"
                                 alt="user">

                            <h3>{{ $user->username }}</h3>
                            <h6>{{ $user->address }}, {{ $user->country }}</h6>
                            <p>{{ $user->description }}</p>
                            <div class="buttons">
                                <div class="button">
                                    <form action="{{ route('matchmaking.show') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="user_id" value="{{ $user->u1 }}">
                                        <button type="submit" class="primary ghost">Show more</button>
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
                </div>
            @endif
            <div class="fs-s"></div>
        </div>
    </div>
@endsection
