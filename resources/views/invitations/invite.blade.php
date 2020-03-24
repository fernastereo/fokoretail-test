@extends('layouts.app')

@section('content')
  <invitation-form-component :user="{{ auth()->user() }}"></invitation-form-component>
@endsection