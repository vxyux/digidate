@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <h1>The pickup line center</h1>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">The line:</th>
                    <th scope="col">Action:</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <a class="btn btn-success" href="{{ route('admin_sentences.create') }}">Add a new line</a>

                <div class="fs-s"></div>

                @foreach($crud as $cruds)
                    @php
                        $line = str_replace("{{ user->first_name }}", "(name)", $cruds->content);
                    @endphp
                    <tbody>
                    <td> {{ $line }} </td>
                    <td>
                        <form action="{{ route('admin_sentences.edit', $cruds->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin_sentences.destroy', $cruds->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    </tbody>
                @endforeach

            </table>
        </div>
    </div>
@endsection
