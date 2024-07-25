<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Body</th>
        <th>Creator</th>
        <th>Car</th>
        <th>Model</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($advertisements as $advertisement)
        <tr>
            <td>{{ $advertisement->id }}</td>
            <td>{{ $advertisement->body }}</td>
            <td>{{ $advertisement->creator }}</td>
            <td>{{ $advertisement->car }}</td>
            <td>{{ $advertisement->model }}</td>
            <td>{{ $advertisement->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
