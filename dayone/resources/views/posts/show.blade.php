@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">{{ $post['title'] }}</h3>
            </div>
            <div class="card-body">
                @if(file_exists(public_path('storage/images/'.$post['image'])))
                    <img src="{{ asset('storage/images/' . $post['image']) }}" 
                         class="img-fluid mb-3 rounded" 
                         alt="{{ $post['title'] }}">
                @else
                    <div class="alert alert-info">
                        Image placeholder: {{ $post['image'] }}
                    </div>
                @endif
                <p class="card-text lead">{{ $post['description'] }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">← All Posts</a>
            </div>
        </div>
    </div>
</div>
@endsection