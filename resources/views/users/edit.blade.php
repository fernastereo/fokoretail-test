@extends('layouts.app')

@section('content')
  <profile-component :user="{{ auth()->user() }}"></profile-component>
@endsection