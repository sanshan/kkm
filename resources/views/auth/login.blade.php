@extends('layouts.app')

@section('content')

    <section class="columns">
        <div class="column is-4 is-offset-4">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="email" class="label">@lang('E-Mail Address')</label>

                    <div class="control">
                        <input id="email" type="email" class="input @error('email') is-danger @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="help is-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label">@lang('Password')</label>

                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror"
                               name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="help is-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                {{--                <div class="form-group row">--}}
                {{--                    <div class="col-md-6 offset-md-4">--}}
                {{--                        <div class="form-check">--}}
                {{--                            <input class="form-check-input" type="checkbox" name="remember"--}}
                {{--                                   id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                {{--                            <label class="form-check-label" for="remember">--}}
                {{--                                {{ __('Remember Me') }}--}}
                {{--                            </label>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="field">
                    <div class="comtrol">
                        <b-button
                            type="is-primary"
                            native-type="submit">
                            @lang('Enter')
                        </b-button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
