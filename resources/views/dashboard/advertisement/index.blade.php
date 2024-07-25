@extends('dashboard.core.layout')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Advertisements</h1>
            </div>
            <div class="col-md-2">
                <h1 class="h3 mb-2 text-gray-800">
                    <a href="{{ route('dashboard.export.index') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-file-excel"></i> Excel
                    </a>
                </h1>
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
                <th>Applier</th>
                <th>Car</th>
                <th>Model</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($advertisements as $advertisement)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $advertisement->creator }}</td>
                        <td>{{ $advertisement->car }}</td>
                        <td>{{ $advertisement->model }}</td>
                        <td>{{ $advertisement->price }}</td>
                        <td>{{ date('d.m.Y H:i', strtotime($advertisement->created_at)) }}</td>
                        <td>
                            <span class="badge badge-pill badge-{{ $advertisement->status_color }}">{{ $advertisement->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('dashboard.advertisement.show', $advertisement->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if ($advertisement->status == 1)
                                <a href="{{ route('dashboard.advertisement.approve', $advertisement->id) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i>
                                </a>
                                <a href="{{ route('dashboard.advertisement.reject', $advertisement->id) }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-x"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $advertisements->links() }}
    </div>
@endsection
