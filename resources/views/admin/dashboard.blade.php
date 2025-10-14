@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-center text-blue-600">Admin Dashboard</h1>
    <p class="mt-4 text-center">Welcome, {{ Auth::user()->name }}! You are logged in as <strong>Admin</strong>.</p>
</div>
@endsection
