<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion</title>
    <link rel="shortcut icon" href="{{ url('control/images/nft/mtwcomplet.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet"> 
    <link href="{{ url('control/css/style_google.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="login-card">
        <img src="{{ url('control/images/nft/mtwlogo_dark.png')}}"alt="Logo"
             class="logo">
        <h2>Connexion</h2>
        <p class="subtitle">Connectez-vous à votre compte</p>

        <form action="{{ route('verification') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email"  placeholder="Entrer votre email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>
            </div>

            <a href="#" class="forgot">Mot de passe oublié ?</a>

            <div class="actions">
                <a href="{{ route('inscription') }}" class="register">Créer un compte</a>
                <button type="submit">Se connecter</button>
            </div>

        </form>

    </div>
<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>
</html>