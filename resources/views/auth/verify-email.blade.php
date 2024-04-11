@extends('layout.app')

@section('title', 'Подтвердите e-mail')

@section('content')
    @include('partials.header')

    <p>Необхідне підтвердження email</p>

    <a href="{{ route('verification.send') }}">
        Відправити знову
    </a>
@endsection

