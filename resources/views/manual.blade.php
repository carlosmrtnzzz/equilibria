@extends('layouts.base')
@section('title', 'Manual de usuario | ')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
        <div id="root"></div>
    </div>
@endsection

@vite('resources/js/react/main.jsx')