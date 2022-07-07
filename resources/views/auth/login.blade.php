@extends("theme.sivycAuth.app")

@section('title', 'Sivyc | Inicio de Sesión')

@section('content')
<br>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> <br>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inicio de Sesión') }}

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sistema" class="col-md-4 col-form-label text-md-right">Sistema</label>
                            <div class="col-md-6">

                                <select name="sistema" class="form-control">
                                    <option selected value="SIVYC">SIVYC</option>
                                    <option value="SIATA">SIATA</option>
                                    <option value="ACTIVIDADES">ACTIVIDADES</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <a type="button" onclick="login()" class="btn btn-primary" style="color:white">{{ __('Iniciar Sesión') }}</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function login()

    $.ajax({
        url: "127.0.0.1:9000/login",
        type: 'POST',
        data: {
            "email": $('#email').val(),
            "password": $('#password').val(),
        },
        success: function(data) {
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('algo salio mal con la peticion del ajax');
            reject();
        }
    });
</script>


@endsection