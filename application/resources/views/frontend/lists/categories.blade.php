@extends('layouts.app')
@foreach($categories as $category)
    <li><a class="dropdown-item" href="#">{{ $category->name }}</a></li>
@endforeach
