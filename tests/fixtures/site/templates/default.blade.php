@extends('layouts.main')

@section('content')
    <h1>{{ $page->title() }}</h1>
    @snippet('greeting', ['name' => 'Spike'])
@endsection
