@extends('dashboard.core.layout')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Create Car</h1>

        <form action="{{ route('dashboard.car.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="">Name</label>
                <input class="form-control" type="text" name="name">
            </div>

            <button class="btn btn-sm btn-block btn-primary" type="submit">
                CREATE
            </button>
        </form>
    </div>
@endsection
