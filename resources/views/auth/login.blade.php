@extends('layouts.app')

@section('content')
<b-container>
    <b-row>
        <b-col></b-col>
        <b-col cols="6">
            <b-card
                header="Login"
                header-tag="header"
            >
                <b-alert show>Default Alert</b-alert>
                <b-form method="POST" action="{{ route('login') }}">
                    @csrf
                    <b-form-group
                        label-cols-sm="3"
                        description="Let us know your email."
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
                            autofocus
                            placeholder="your_email@example.com"
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
                            value="{{ old('password') }}" 
                            required 
                            autocomplete="current-password" 
                        ></b-form-input>
                    </b-form-group>

                    <b-container>
                        <b-row>
                            <b-col cols="3"></b-col>
                            <b-col>
                                <b-form-group>
                                    <b-form-checkbox
                                        id="remember"
                                        name="remember"
                                        {{ old('remember') ? 'checked="true"' : '' }}
                                    >
                                    {{ __('Remember Me') }}
                                    </b-form-checkbox>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-container>

                    <b-container>
                        <b-row>
                            <b-col cols="3"></b-col>
                            <b-col>
                                <b-button type="submit" variant="primary">{{ __('Login') }}</b-button>

                                <b-button href="{{ route('password.request') }}" variant="link">{{ __('Forgot Your Password?') }}</b-button>
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
