@extends('layouts.app')
@section('title', __('Hakkımızda'))
@section('content')
    <div class="container">
        <h2 class="game-header">{{ __('Hakkımızda') }}</h2>
        <div class="game-info mb-2 mt-2 p-3 rounded">
            <p>
                {!! $settings->about_text !!}
            </p>
        </div>
    </div>
@endsection
