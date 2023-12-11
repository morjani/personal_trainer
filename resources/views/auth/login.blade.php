@extends('auth.master')

@section('title', 'Login')

@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-verychic bg-soft">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h5>Bienvenue !</h5>
                                        <p>Connectez-vous pour continuer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="p-2">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="form-horizontal" action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Saisir l'adresse email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mot de passe</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="password" placeholder="Saisir le mot de passe" aria-label="Password" aria-describedby="password-addon" required>
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn bg-verychic border-verychic-color text-white  waves-effect waves-light" type="submit">Se connecter</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>document.write(new Date().getFullYear())</script>
                                Kaimove with
                                <i class="mdi mdi-heart text-danger"></i> by AVB</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
