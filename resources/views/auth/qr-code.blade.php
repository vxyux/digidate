@extends('master')

@section('content')
    <div class="background">
        <div class="container">

            <div class="d-flex justify-content-center">
                <h1>2FA QR code</h1>
            </div>

            <div class="d-flex justify-content-center p-5">
                {!! $twofa->QRcode !!}
            </div>

            {{--
                the first value defines [id] if the QR code is being accepted
                second value defines [type] if it comes from the register (0) or profile (1)
            --}}
            @if(Auth::user()->email_verified_at == null)

                <div class="d-flex justify-content-center p-5">
                    <form action="{{ route('qr-accept', ['id' => 1, 'type' => 0]) }}">
                        <button type="submit" class="btn btn-success">Setup right now</button>
                    </form>
                </div>

                <div class="d-flex justify-content-center p-5">
                    <form action="{{ route('qr-decline', ['id' => 0, 'type' => 1]) }}">
                        <button type="submit" class="btn btn-danger">Setup later...</button>
                    </form>
                </div>

            @else

                <div class="d-flex justify-content-center p-5">
                    <form action="{{ route('qr-accept', ['id' => 1, 'type' => 1]) }}">
                        <button type="submit" class="btn btn-primary">Authenticate</button>

                    </form>
                </div>

                <div class="d-flex justify-content-center p-5">
                    <form action="{{ route('qr-decline', ['id' => 0, 'type' => 1]) }}">
                        <button type="submit" class="btn btn-danger">Setup later...</button>
                    </form>
                </div>

            @endif

        </div>
    </div>

@endsection
