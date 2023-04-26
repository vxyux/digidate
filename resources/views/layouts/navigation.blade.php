<div class="sidebar" id="sidebar">
    <div class="s-container">
        <ul class="link-items">
            <li class="link-item top {{ request()->is('profile') ? 'active' : '' }}">
                @if(Auth::user() )
                    <a href="{{ url('/profile') }}">
                        @if(Auth::user()->images()->get()[0]['image'] == '/media/user.jpg')
                            <img
                                 src="{{ asset('storage/media/user.jpg')}}"
                                 alt="user" id="profile-img" >
                        @else
                            <img
                                 src="{{ asset('storage/media/' . Auth::user()->username . '/profilePicture/' . Auth::user()->images()->get()[0]['image']) }}" alt="" id="profile-img" />

                        @endif
                        @else
                            <a href="{{ url('/login') }}">

                                @endif

                                <span style="--i: 9">
                        @if(Auth::user())
                                        <h4 class="nav-name">
                                {{ Auth::user()->first_name }}
                            </h4>
                                    @else
                                        <h4 class="nav-name">Guest</h4>
                                    @endif
                    </span>
                            </a>
                    </a>
            </li>
            <!--
                icons for the nav selectable here: https://ionic.io/ionicons
            -->
            @if(Auth::user())
                <li class="link-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}" class="link">
                        <ion-icon name="home"></ion-icon>
                        <span style="--i: 1">Home</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}" class="link">
                        <ion-icon name="cube"></ion-icon>
                        <span style="--i: 2">dashboard</span>
                    </a>
                </li>
                @client
                <li class="link-item {{ request()->is('enterprise') ? 'active' : '' }}">
                    <a href="{{ route('enterprise.index') }}" class="link"
                    ><ion-icon name="sparkles"></ion-icon>
                        <span style="--i: 3">Enterprise</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('matchmaking') ? 'active' : '' }}">
                    <a href="{{ route('matchmaking.index') }}" class="link"
                    ><ion-icon name="people"></ion-icon>
                        <span style="--i: 3">Matchmaking</span>
                    </a>
                </li>

                <li class="link-item {{ request()->is('chat') ? 'active' : '' }}">
                    <a href="{{ route('chat.index') }}" class="link">
                        <ion-icon name="chatbubbles"></ion-icon>
                        <span style="--i: 3">Chats</span>
                    </a>
                </li>

                <li class="link-item {{ request()->is('block_view') ? 'active' : '' }}">
                    <a href="{{ route('blocked') }}" class="link">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span style="--i: 3">Blocked users</span>
                    </a>
                </li>
                @endclient
                @enterpriser

                <li class="link-item {{ request()->is('matchmaking') ? 'active' : '' }}">
                    <a href="{{ route('matchmaking.index') }}" class="link"
                    ><ion-icon name="people"></ion-icon>
                        <span style="--i: 3">Matchmaking</span>
                    </a>
                </li>

                <li class="link-item {{ request()->is('chat') ? 'active' : '' }}">
                    <a href="{{ route('chat.index') }}" class="link">
                        <ion-icon name="chatbubbles"></ion-icon>
                        <span style="--i: 3">Chats</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('block_view') ? 'active' : '' }}">
                    <a href="{{ route('blocked') }}" class="link">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span style="--i: 3">Blocked users</span>
                    </a>
                </li>
                @endenterpriser
                @admin
                <li class="link-item {{ request()->is('enterprise') ? 'active' : '' }}">
                    <a href="{{ route('enterprise.create') }}" class="link"
                    ><ion-icon name="sparkles"></ion-icon>
                        <span style="--i: 3">Subscribers</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('admin_users') ? 'active' : '' }}">
                    <a href="{{ route('admin_users.index') }}" class="link"
                    ><ion-icon name="person-add"></ion-icon>
                        <span style="--i: 3">Users</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('admin_tags') ? 'active' : '' }}">
                    <a href="{{ route('admin_tags.index') }}" class="link"
                    ><ion-icon name="pricetags"></ion-icon>
                        <span style="--i: 3">Tags</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('admin_sentences') ? 'active' : '' }}">
                    <a href="{{ route('admin_sentences.index') }}" class="link"
                    ><ion-icon name="chatbox-ellipses"></ion-icon>
                        <span style="--i: 3">Sentences</span>
                    </a>
                </li>
                @endadmin
                <li class="link-item">
                    <a href="{{ url('logout') }}" class="link">
                        <ion-icon name="log-out"></ion-icon>
                        <span style="--i: 2"><span style="color: red">Log out</span></span>
                    </a>
                </li>
            @else
                <li class="link-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}" class="link">
                        <ion-icon name="home"></ion-icon>
                        <span style="--i: 1">Home</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('enterprise') ? 'active' : '' }}">
                    <a href="{{ route('enterprise.index') }}" class="link"
                    ><ion-icon name="sparkles"></ion-icon>
                        <span style="--i: 3">Enterprise</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('register') ? 'active' : '' }}">
                    <a href="{{ url('register') }}" class="link">
                        <ion-icon name="person-add"></ion-icon>
                        <span style="--i: 2">Register</span>
                    </a>
                </li>
                <li class="link-item {{ request()->is('login') ? 'active' : '' }}">
                    <a href="{{ url('login') }}" class="link">
                        <ion-icon name="log-in"></ion-icon>
                        <span style="--i: 2">Login</span>
                    </a>
                </li>
            @endif
            <li class="link-item dark-mode">
                <a href="#" class="link">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span style="--i: 8">Dark Mode</span>
                </a>
            </li>
        </ul>
    </div>
</div>

