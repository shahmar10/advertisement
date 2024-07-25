@extends('dashboard.core.layout')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Car Import</h1>
            </div>
        </div>

        <form action="{{ route('dashboard.car.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="file" name="cars" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-success">Import</button>
        </form>

    </div>

@endsection
