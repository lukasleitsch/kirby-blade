@extends('layouts.main')

@section('content')
    <h1>{{ $page->title() }}</h1>
    @snippet(['missing', 'greeting'], ['name' => 'Spike'])
@endsection
