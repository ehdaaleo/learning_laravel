@extends('layouts.app')

@section('content')
<div id="slider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#slider" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#slider" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#slider" data-bs-slide-to="2"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://picsum.photos/id/101/1200/400" class="d-block w-100" alt="Slide 1">
            <div class="carousel-caption d-none d-md-block">
                <h5>Welcome to ITIBlog</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://picsum.photos/id/104/1200/400" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="https://picsum.photos/id/106/1200/400" class="d-block w-100" alt="Slide 3">
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="text-center mt-5">
    <h1>Welcome to ITIBlog</h1>
    <p>Your source for amazing content</p>
</div>
@endsection