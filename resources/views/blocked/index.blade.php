@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <h1>Blocked users</h1>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name:</th>
                    <th scope="col">Action:</th>
                </tr>
                </thead>

                <div class="fs-s"></div>

                @foreach($blocked_users as $blocked)
                    <tbody>
                    <td> {{ $blocked->username }} </td>
                    <td>
                        <form action="{{ route('unblock', $blocked->user_id_2) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">
                                Unblock
                            </button>
                        </form>
                    </td>
                    </tbody>
                @endforeach

            </table>
            <div class="fs-xl"></div>
        </div>
    </div>
@endsection
