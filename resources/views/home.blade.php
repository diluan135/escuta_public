@extends('master')

@section('contento')
    @auth
        <div id="app">
            <App />
        </div>
    @else
        @error('error')
            <span>{{ $message }}</span>
        @enderror

        <body class="body-container">
            
            <div class="principal left">
                <h2 class="lemon-font text-dark" style="text-decoration: underline;" >Novo login</h2>

                <div>
                    <p class="fw-normal lemon-font mb-0">É A SUA PRIMEIRA VISITA?</p>
                    <h1 class="lemon-font" >REGISTRE-SE</h1>
                </div>

                <a class="botao branco" href="{{ route('login.registro') }}">Criar nova conta</a>
            </div>

            <div class="principal right">
                <form class="d-flex flex-column justify-content-center align-items-center gap-3" action="{{ route('login.store') }}" method="post">
                    @csrf
                    <!-- <h1 class="lemon-font text-white" style="text-shadow: none;">Login</h1> -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="lemon-font" style="text-shadow: none; width: 175px; height: auto; margin-bottom: 1rem;">

                    <div class="input-container">
                        <input class="my-input" type="text" id="cpf" placeholder="CPF" name="cpf" value="{{ old('cpf') }}" required oninput="formatCPF(this)" maxlength="14">
                        @error('cpf')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>       

                    <div class="input-container">
                        <input class="my-input" type="password" placeholder="Senha" id="password" name="password" required>
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i id="passwordIcon" class="fa fa-eye"></i>
                        </button>
                        @error('password')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <a class="text-white" href="">Esqueceu sua senha?</a>
                    
                    <button class="botao azul" type="submit">Entrar</button>
                </form>
            </div> 
        </body>

        <script>
            function formatCPF(input) {
                let value = input.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length <= 3) {
                    input.value = value;
                } else if (value.length <= 6) {
                    input.value = value.replace(/(\d{3})(\d+)/, '$1.$2');
                } else if (value.length <= 9) {
                    input.value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
                } else {
                    input.value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                }
            }

            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordField = document.getElementById('password');
                const passwordIcon = document.getElementById('passwordIcon');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
        </script>
    @endauth
@endsection
