@extends('master')

@section('content')
    <div class="background">
        <div class="container">
            <div class="fs-s"></div>
    <h1>User management</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name:</th>
                    <th scope="col">Admin:</th>
                    <th scope="col">Action:</th>
                </tr>
            </thead>

            <a class="btn btn-success" href="{{ route('admin_users.create') }}">Add a new admin</a>

            <div class="fs-s"></div>

            @foreach($crud as $cruds)
              <tbody>
                    <td> {{ $cruds->first_name }} {{ $cruds->infix }} {{ $cruds->last_name }}</td>
                    <td> {{ $cruds->is_admin ? 'yes' : 'no' }}</td>
                    <td>
                        <form action="{{ route('admin_users.destroy', $cruds->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger"
                            @if(Auth::user()->id == $cruds->id)
                                disabled
                            @else
                            @endif
                            >
                                Delete
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
