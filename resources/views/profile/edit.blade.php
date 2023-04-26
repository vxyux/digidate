@extends('master')

@section('content')
<body>
    <div class="background">
        <div class="container">
        <div class="fs-m"></div>
        <h1>Account management</h1>
        <div class="fs-s"></div>
            <form action="{{ route('profile.images') }}" enctype="multipart/form-data" method="POST">
                @method('POST')
                @csrf
                <div class="fs-xxs"></div>
                <div class="row">
                    <div class="col-sm-6">
                        @if($userInfo[0]['image'] == '/media/user.jpg')
                            <img class="round profile mx-auto"
                                 src="{{ asset('storage/media/user.jpg')}}"
                                 alt="user">
                        @else
                            <img class="round profile mx-auto"
                                 src="{{ asset('storage/media/' . Auth::user()->username . '/profilePicture/' . $userInfo[0]['image']) }}"
                                 alt="user">
                        @endif

                    </div>
                    <div class="col-sm-6">
                        <br>
                        <label for="name">
                            Profile picture
                        </label>
                        <div class="img-center">
                            <input type="file"  name="image"/>
                        </div>
                        <div class="fs-xxs"></div>
                    </div>
                </div>
                <div class="fs-s"></div>
                <div class="row">
                @for($i = 2; $i < 6; $i++)
                    <div class="col-sm-6">
                        <br>
                        <label for="name">
                            Image {{ $i }}
                        </label>
                        <div class="img-center">
                            <input type="file" name="images[]"/>
                        </div>
                        <div class="fs-xxs"></div>
                    </div>
                @endfor
                </div>
                <div class="fs-xxs"></div>
                <button type="submit" class="btn btn-primary btn-lg align-r">Save images</button>
            </form>
            <div class="fs-s"></div>
            <form action="{{ route('profile.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm">
                        <label for="name">First name</label>
                        <div class="card">
                            <input name="first_name" type="text" value="{{ $user->first_name }}" class="card-body">
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="name">Infix</label>
                        <div class="card">
                            <input name="infix" value="{{ $user->infix }}" class="card-body">
                        </div>
                    </div>

                    <div class="col-sm">
                        <label for="name">Last name</label>
                        <div class="card">
                            <input name="last_name" value="{{ $user->last_name }}" class="card-body">
                        </div>
                    </div>
                </div>
                <div class="fs-s"></div>
                <label for="name">Email</label>
                <div class="card">
                    <input name="email" value="{{ $user->email }}" class="card-body">
                </div>
                <div class="fs-s"></div>

                <label for="name">Day of birth</label>
                <div class="card">
                    <input name="dob" max="03-07-2004" type="date" value="{{ $user->dob }}" class="card-body" disabled>
                </div>

                <div class="fs-s"></div>
                <div class="row">
                    <div class="col-sm">
                        <label for="name">Address</label>
                        <div class="card">
                            <input name="address" value="{{ $user->address }}" class="card-body">
                        </div>
                    </div>

                    <div class="col-sm">
                        <label for="name">Country</label>
                        <div class="card">
                            <input name="country" value="{{ $user->country }}" class="card-body">
                        </div>
                    </div>
                </div>
                <div class="fs-s"></div>
                <div class="row">
                    <div class="col-sm">
                        <label for="name">Zipcode</label>
                        <div class="card">
                            <input name="zipcode" value="{{ $user->zipcode }}" class="card-body">
                        </div>
                    </div>

                    <div class="col-sm">
                        <label for="name">House number</label>
                        <div class="card">
                            <input name="street_nr" value="{{ Auth::user()->street_nr }}" class="card-body">
                        </div>
                    </div>
                </div>
                <div class="fs-s"></div>

                <div class="row">
                    <div class="col-sm">
                        <label for="name">Gender</label>
                        <div class="card">
                            <select name="gender" id="" class="form-control">
                                @if(Auth::user()->gender == 0)
                                    <option value="0"  selected>Male</option>
                                @elseif(Auth::user()->gender == 1)
                                    <option value="1"  selected>Female</option>
                                @else
                                    <option value="2"  selected>Other</option>
                                @endif
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                                <option value="2">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="name">Phone number</label>
                        <div class="card">
                            <input name="phone" type="number" value="{{ $user->phone }}" class="card-body">
                        </div>
                    </div>
                </div>
                <div class="fs-s"></div>

                    <h1>Profile management</h1>

                <div class="fs-xxs"></div>

                <div class="row">
                    <div class="col-sm">
                        <label for="name">Username</label>
                        <div class="card">
                            <input name="username" value="{{ $user->username }}" class="card-body">
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="name">Orientation</label>
                        <div class="card">
                            <select name="orientation" id="" class="form-control">
                                @if(Auth::user()->orientation == 0)
                                    <option value="0"  selected>Heterosexual</option>
                                @elseif(Auth::user()->orientation == 1)
                                    <option value="1"  selected>Bisexual</option>
                                @else
                                    <option value="2"  selected>Homosexual</option>
                                @endif
                                <option value="0">Heterosexual</option>
                                <option value="1">Bisexual</option>
                                <option value="2">Homosexual</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="fs-s"></div>

                <div class="row">
                    <div class="col-sm">
                        <label for="name">Your description</label>
                        <div class="card">
                            <input name="description" maxlength="100" type="text" value="{{ $user->description }}" class="card-body">
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="name">Your plan</label>
                        <div class="card">
                            <input name="email" value="
                            @if(Auth::user()->is_enterprise == 1)
                                Enterpriser
                            @else
                                None
                            @endif
                            " class="card-body">
                        </div>
                        <p class="text-muted">Get your Enterprise <a href="{{ route('enterprise.index') }}">here</a>.</p>
                    </div>
                </div>

                <div class="fs-xxs"></div>

                <div class="fs-s"></div>
                <label for="name">Your Tags</label>
                <div class="card">
                    <div class=card-body >
                        @foreach($tags as $tag)
                            <div class="form-check form-switch">
                                <div class="row">
                                <input name="tags[]" class="form-check-input" max="5" type="checkbox" value="{{ $tag->id }}" id="flexSwitchCheckDefault"
                            @if($selected != null)
                            @foreach($selected as $select)

                                @if($tag->id == $select->tag_id) checked @endif

                            @endforeach
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ $tag->name }}</label>
                                    @else
                                        <label class="form-check-label" for="flexSwitchCheckDefault">{{ $tag->name }}</label>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="fs-xxs"></div>
                <label for="name">2FA Security</label>
                <div class="card">
                    <div class="card-body">
                        @if($has_2fa == 0)
                        <span style="color: red"><i class="bi bi-x-circle-fill"></i><strong>&ensp;2FA has not been set.</strong></span>&ensp;
                        <a href="{{ route('qr-redo', ['id' => 2, 'type' => 1]) }}">Configure 2FA here.</a>
                        @else
                        <span style="color: darkgreen"><i class="bi bi-check-circle-fill"></i><strong>&ensp;2FA has been set!</strong></span>
                            <a href="{{ route('qr-redo', ['id' => 2, 'type' => 1]) }}">Redo 2FA here.</a>
                        @endif
                    </div>
                </div>

                <div class="fs-xxs"></div>
                <label for="name">Email verified</label>
                <div class="card">
                    <div class="card-body">
                        @if(Auth::user()->email_verified_at == null)
                            <span style="color: red"><i class="bi bi-x-circle-fill"></i><strong>&ensp;Email has not been verified.</strong></span>&ensp;
                        @else
                            <span style="color: darkgreen"><i class="bi bi-check-circle-fill"></i><strong>&ensp;Email has been verified</strong></span>
                        @endif
                    </div>
                </div>

                <div class="fs-s"></div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Save changes</button>
            </form>

            <div class="fs-s"></div>

            <label for="name">Danger zone</label>
            <div class="card bg-danger mb-3">
                <div class="card-body">
                    <a href="#popup">
                        <button type="submit" class="btn btn-outline-danger">Delete account</button>
                        <small id="emailHelp" class="form-text text-white ">This action is not undoable. Think about it.</small>
                    </a>
                </div>
            </div>
            <section id="images"></section>

            <div class="fs-xl"></div>
            <div id="popup">
                <div class="popup-content">
                    <h3>Are you sure you want to delete your account?</h3>
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                        <small id="emailHelp" class="form-text text-white ">This action is not undoable. Think about it.</small>
                    </form>
                    <a href="" class="close-popup">&times;</a>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $("input:checkbox").click(function() {
        var bol = $("input:checkbox:checked").length >= 5;
        $("input:checkbox").not(":checked").attr("disabled",bol);
    });
</script>
@endsection
