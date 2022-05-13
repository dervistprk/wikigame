@extends('layouts.app')
@section('title', 'Hakkında')
@section('content')
    <div class="container">
        <div class="game-info m-3 p-3 rounded">
            <p>
                {!! $settings->about_text !!}
            </p>
        </div>
    </div>
@endsection
