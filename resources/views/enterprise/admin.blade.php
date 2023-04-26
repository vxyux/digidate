@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <h1>Subscribers management</h1>

            <div class="fs-s"></div>

            <h2>Requests</h2>
            <br>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name:</th>
                    <th scope="col">Status:</th>
                    <th scope="col">Action:</th>
                </tr>
                </thead>

                @foreach($crud as $cruds)
                    <tbody>
                    <td> {{ $cruds->first_name }} {{ $cruds->infix }} {{ $cruds->last_name }}</td>
                    <td> Pending confirmation</td>
                    <td>
                        <form action="{{ route('enterprise.edit', $cruds->id) }}" method="GET">
                            @method('GET')
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Grant
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

