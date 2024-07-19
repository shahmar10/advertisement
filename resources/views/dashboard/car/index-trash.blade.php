@extends('dashboard.core.layout')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Deleted Cars</h1>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('dashboard.car.index') }}" class="btn btn-sm btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>



        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ request()->get('name') }}" id="name" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creator">Creator</label>
                        <input type="text" name="creator" value="{{ request()->get('creator') }}" id="creator" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="visibility: hidden">a</div>
                    <button class="btn btn-sm btn-info" type="submit">
                        <i class="fa fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Created By</th>
                <th>Deleted At</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $car->name }}</td>
                        <td>{{ $car->creator ?? '' }}</td>
                        <td>{{ $car->deleted_at }}</td>
                        <td>{{ date('d.m.Y H:i', strtotime($car->created_at)) }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{ route('dashboard.car.delete.back', $car->id) }}">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $cars->links() }}
    </div>
@endsection
