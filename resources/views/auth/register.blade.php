@extends('layouts.app')

@section('content')
<b-container>
    <b-row>
        <b-col></b-col>
        <b-col cols="8">
            <b-card header="{{ __('Register') }}" header-tag="{{ __('Register') }}">
                
                @if($errors->any())
                    <b-alert show variant="danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>    
                            @endforeach
                        </ul>
                    </b-alert>
                @endif

                <b-form method="POST" action="{{ route('register') }}">
                    @csrf
                    <b-form-group
                        label-cols-sm="3"
                        label={{ __('Name') }}
                        label-for="name"
                        label-align="right"
                    >
                        <b-form-input 
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name" 
                            autofocus
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label-cols-sm="3"
                        label={{ __('E-Mail Address') }}
                        label-for="email"
                        label-align="right"
                    >
                        <b-form-input 
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label-cols-sm="3"
                        label={{ __('Password') }}
                        label-for="password"
                        label-align="right"
                    >
                        <b-form-input 
                            id="password"
                            type="password"
                            name="password" 
                            required 
                            autocomplete="new-password" 
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label-cols-sm="3"
                        label={{ __('Confirm Password') }}
                        label-for="password-confirm"
                        label-align="right"
                    >
                        <b-form-input 
                            id="password-confirm"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                        ></b-form-input>
                    </b-form-group>
                    <b-container>
                        <b-row>
                            <b-col cols="3"></b-col>
                            <b-col>
                                <b-button type="submit" variant="primary">{{ __('Register') }}</b-button>
                            </b-col>
                        </b-row>
                    </b-container>
                </b-form>
            </b-card>
        </b-col>
        <b-col></b-col>
    </b-row>
</b-container>
@endsection
