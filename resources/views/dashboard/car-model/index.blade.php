@extends('dashboard.core.layout')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Car's Models</h1>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('dashboard.car-model.index.trash') }}" class="btn btn-sm btn-warning">Trash</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('dashboard.car-model.create') }}" class="btn btn-sm btn-info">Create</a>
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
                <th>Car</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($models as $model)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->car }}</td>
                        <td>{{ $model->creator ?? '' }}</td>
                        <td>{{ date('d.m.Y H:i', strtotime($model->created_at)) }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.car-model.edit', $model->id) }}">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="{{ route('dashboard.car-model.delete', $model->id) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $models->links() }}
    </div>
@endsection
