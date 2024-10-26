@extends('layout')

@section('title', 'Profile')

@section('content')
<h1>{{ Auth::user()->name }}'s Profile</h1>
<p> Name: {{ Auth::user()->name }}</p>
<p> Email: {{ Auth::user()->email }}</p>

@endsection