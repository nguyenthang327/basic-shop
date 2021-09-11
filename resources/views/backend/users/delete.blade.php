@extends('backend.layouts.main')

@section('title', 'Xóa users')

@section('content')
    <h1>Xóa users</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form name="admin" action="{{ url("/backend/users/destroy/$user->id") }}" method="post">

        @csrf

        <div class="form-group">
            <label for="product_name">ID user:</label>
            <p>{{ $user->id }}</p>
        </div>

        <div class="form-group">
            <label for="product_name">Tên user:</label>
            <p>{{ $user->name }}</p>
        </div>

        <div class="form-group">
            <label for="product_name">Email user:</label>
            <p>{{ $user->email }}</p>
        </div>

        <button type="submit" class="btn btn-danger">Xác nhận xóa!</button>
    </form>

@endsection

