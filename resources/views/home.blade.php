@extends('layouts.app')

@section('content')
<chat-component :user-id="{{ auth()->id() }}"></chat-component>
@endsection
