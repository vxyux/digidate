@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <h1>Just chatting </h1>
            <div class="fs-s"></div>
            <div class="row col-12">
                <div class="card-chat col-4">
                    <h3 class="text-center">Your matches</h3>
                        @foreach($select as $match)
                            @if($match->id1 == $id)
                                <a href="{{ url('chat', $match->id) }}" class="card py-2 element-center" style="text-decoration: none; color: inherit">
                                            <img class="small_image" src="{{ asset('storage/media/' . $match->username1 . '/profilePicture/' . $match->image1) }}">
                                            <p> <b>{{ $match->username2 }}</b></p>
                                </a>
                            @else
                                <a href="{{ url('chat', $match->id) }}" class="card py-2 element-center"  style="text-decoration: none; color: inherit">

                                    <img class="small_image" src="{{ asset('storage/media/' . $match->username1 . '/profilePicture/' . $match->image1) }}">
                                            <p> <b>{{ $match->username1 }}</b> </p>
                                </a>
                            @endif
                        @endforeach
                </div>

                <div class="card-chat col-7">
                    @if($selected == 0)
                        <div class="fs-l"></div>
                        <h3>Select a chat</h3>
                    @else
                        <a href="#popup">
                            <button class="btn btn-danger"><ion-icon name="flag"></ion-icon> Block</button>
                        </a>
                        <a href="#popup-2">
                            <button class="btn btn-warning"><ion-icon name="heart-dislike"></ion-icon> Unmatch</button>
                        </a>
                        <section class="msger">
                            <header class="msger-header">
                                <div class="msger-header-title">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div class="msger-header-options">
                                    <span><i class="fas fa-cog"></i></span>
                                </div>
                            </header>

                            <main class="msger-chat" id="msger-id">
                                @foreach($chat_data as $chat)
                                    @if($chat->sender_id != Auth::user()->id)
                                        <div class="msg left-msg">
                                            <div
                                                class="msg-img">
                                            <img class="round profile mx-auto" style="width: 3em; height: 3em"
                                                 src="{{ asset('storage/media/' . $chat->username . '/profilePicture/' . $chat->image) }}"
                                                 alt="user">
                                            </div>

                                            <div class="msg-bubble">
                                                <div class="msg-info">
                                                    <div class="msg-info-name">{{ $chat->username }}</div>
                                                    <div class="msg-info-time">{{ date('H:i', strtotime($chat->created_at)) }}</div>
                                                </div>

                                                <div class="msg-text">
                                                    {{ $chat->text }}
                                                </div>

                                            </div>
                                        </div>
                                    @else
                                        <div class="msg right-msg">
                                            <div
                                                class="msg-img">
                                                <img class="round profile mx-auto" style="width: 3em; height: 3em"
                                                     src="{{ asset('storage/media/' . $chat->username . '/profilePicture/' . $chat->image) }}"
                                                     alt="user">
                                            </div>
                                            <div class="msg-bubble">
                                                <div class="msg-info">


                                                    <div class="msg-info-name">{{ $chat->username }}</div>
                                                    <div class="msg-info-time">{{ date('H:i', strtotime($chat->created_at)) }}</div>
                                                </div>

                                                <div class="msg-text">
                                                    {{ $chat->text }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </main>

                            <form action="{{ route('chat_with_user', $match_id) }}" method="POST" class="msgform">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="my_name" id="name" value="{{ Auth::user()->username }}">
                                <input type="hidden" name="my_id" id="id" value="{{ Auth::user()->id }}">
                                <input type="text" class="input_class col-10" name="my_text" id="text" placeholder="Enter your message...">
                                <button type="submit" class="msger-send-btn">Send</button>
                            </form>

                            @if ($chat_data->isNotEmpty())
                            @elseif(Auth::user()->is_enterprise == 1)
                                <form action="{{ route('use_sentences', $match_id) }}" method="POST">
                                    @method('POST')
                                    @csrf
                                    @foreach($sentences as $sentence)
                                        <input type="hidden" name="retriever" value="{{ $retriever }}">
                                        <button type="submit" name="sentence" value="{{ $sentence->content }}" class="btn btn-sm btn-primary">{{ $sentence->content }}</button>
                                    @endforeach
                                </form>
                            @endif
                            <div class="fs-xxs"></div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
        <div class="fs-l"></div>
    </div>

    <script type="text/javascript">

        var messageBody = document.querySelector('#msger-id');
        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

        setTimeout(function () {
                document.location.reload()
            }, 15000
        )
    </script>

<div id="popup">
    <div class="popup-content">
        <h2>Blocking: are you sure?</h2>
        <hr>
        <p>This action is irreversible, deleting the chat and reporting it in the process.</p>
        <a href="" class="close-popup">&times;</a>
        @isset($data)
            <form action="{{ route('block') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="mid" value="{{ $match_id }}">
                <input type="hidden" name="u1" value="{{ $data->id1 }}">
                <input type="hidden" name="u2" value="{{ $data->id2 }}">
                <button class="btn btn-sm btn-danger">Officially block</button>
            </form>
        @endisset
    </div>
</div>

<div id="popup-2">
    <div class="popup-content">
        <h2>Unmatch: are you sure?</h2>
        <hr>
        <p>This action is irreversible, you can still read the chat history.</p>
        <a href="" class="close-popup">&times;</a>
        @isset($data)
            <form action="{{ route('unmatch') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="mid" value="{{ $match_id }}">
                <input type="hidden" name="u1" value="{{ $data->id1 }}">
                <input type="hidden" name="u2" value="{{ $data->id2 }}">
                <button class="btn btn-sm btn-warning">Officially unmatch</button>
            </form>
        @endisset
    </div>
</div>

@endsection
