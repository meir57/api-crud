@extends('layouts.main')

@section('app-name', 'To Do List')

@section('todo')

    <header>
        <span class="logout">logout</span>
    </header>

    <div class="pwa">
        <h1 class="app-name">@yield('app-name')</h1>

        @include('login')
        
        @include('add-task')
        @include('list-tasks')
    </div>

@endsection