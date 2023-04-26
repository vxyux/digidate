@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
            <h1>Tag management</h1>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name:</th>
                    <th scope="col">Action:</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <a class="btn btn-success" href="{{ route('admin_tags.create') }}">Add a new tag</a>

                <div class="fs-s"></div>

                @foreach($crud as $cruds)
                    <tbody>
                    <td> {{ $cruds->name }} </td>
                    <td>
                        <form action="{{ route('admin_tags.edit', $cruds->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin_tags.destroy', $cruds->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    </tbody>
                @endforeach

            </table>
            <div class="fs-xl"></div>
        </div>
    </div>
@endsection
