<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Registro</title>
    @vite('resources/css/reset.css')
    @vite('resources/css/style.css')
</head>

<body class="body-container">
    <main>
        <div class="principal center">
            <h1 class="lemon-font text-white text-shadow">Registre-se</h1>

            @if ($errors->any())
            <div>
                <ul class="d-flex flex-row gap-2 ul-error">
                    @foreach ($errors->all() as $error)
                    <li class="li-error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="form-container d-flex flex-column justify-center align-items-center gap-4" method="POST" action="{{ route('login.registro') }}">
                @csrf
                <div class="d-flex flex-row justify-center align-items-center gap-5">
                    <div class="d-flex flex-column justify-center align-items-center">
                        <div class="input-container mb-2">
                            <label for="name" class="labelInput">Nome</label>
                            <input class="my-input" type="text" id="name" name="name" placeholder="Nome" value="{{ old('name') }}" required maxlength="255">
                        </div>
                        <div class="input-container mb-2">
                            <label for="sobrenome" class="labelInput">Sobrenome</label>
                            <input class="my-input" type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{ old('sobrenome') }}" required maxlength="255">
                        </div>
                        <div class="input-container mb-2">
                            <label for="cpf" class="labelInput">CPF</label>
                            <input class="my-input" type="text" id="cpf" name="cpf" placeholder="CPF" value="{{ old('cpf') }}" required oninput="formatCPF(this)" maxlength="14">
                        </div>
                    </div>

                    <div>
                        <div class="input-container mb-2">
                            <label for="email" class="labelInput">Email</label>
                            <input class="my-input" type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required maxlength="255">
                        </div>
                        <div class="input-container mb-2">
                            <label for="password" class="labelInput">Senha</label>
                            <input class="my-input" type="password" id="password" name="password" placeholder="Senha" required minlength="8">
                            <button type="button" class="toggle-password" data-target="password">
                                <i style="margin-top: 35px;" class="fa fa-eye"></i>
                            </button>
                        </div>
                        <div class="input-container mb-2">
                            <label for="password_confirmation" class="labelInput">Confirme a senha</label>
                            <input class="my-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="Senha" required minlength="8">
                            <button type="button" class="toggle-password" data-target="password_confirmation">
                                <i style="margin-top: 35px;" class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>  

                <div class="d-flex flex-row">
                    <input class="me-2" type="checkbox" id="exampleCheckbox" name="terms" required>
                    <label class="text-white" for="exampleCheckbox">Concordo com os Termos e Condições</label>
                </div>

                <button class="botao azul" type="submit">Registrar</button>
            </form>
        </div>
    </main>
    @vite('resources/js/app.js')
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

    document.addEventListener("DOMContentLoaded", function() {
        const password = document.getElementById("password");
        const passwordConfirmation = document.getElementById("password_confirmation");
        const checkbox = document.getElementById("exampleCheckbox");
        const submitBtn = document.getElementById("submitBtn");

        function validatePassword() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity("As senhas não coincidem");
            } else {
                passwordConfirmation.setCustomValidity("");
            }
        }

        function toggleSubmitButton() {
            submitBtn.disabled = !checkbox.checked || !password.value || !passwordConfirmation.value || password.value !== passwordConfirmation.value;
        }

        password.addEventListener("input", validatePassword);
        passwordConfirmation.addEventListener("input", validatePassword);
        checkbox.addEventListener("change", toggleSubmitButton);
        password.addEventListener("input", toggleSubmitButton);
        passwordConfirmation.addEventListener("input", toggleSubmitButton);
    });

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>

<style>
    .labelInput {
    margin: 0 0 0.25rem 0.5rem;
    font-size: 20px;
}   
</style>

</html>