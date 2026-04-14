@extends('layouts.app')

@section('content')
<h1 class="mb-4">All Posts</h1>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post['title'] }}</td>
            <td>{{ $post['description'] }}</td>
            <td>
                <a href="{{ route('posts.show', $post['id']) }}" class="btn btn-primary btn-sm">Show</a>
            </td>
            <td><button class="btn btn-warning btn-sm" disabled>Edit</button></td>
            <td><button class="btn btn-danger btn-sm" disabled>Delete</button></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection