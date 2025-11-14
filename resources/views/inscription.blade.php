<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet"> 
    <link href="{{ url('control/css/style_google.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="login-card">

        <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_74x24dp.png"
             alt="Logo"
             class="logo">

        <h2>Connexion</h2>
        <p class="subtitle">Connectez-vous à votre compte</p>

        <form action="#" method="POST">

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" placeholder="Entrer votre email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" placeholder="Entrer votre mot de passe" required>
            </div>

            <a href="#" class="forgot">Mot de passe oublié ?</a>

            <div class="actions">
                <a href="#" class="register">Créer un compte</a>
                <button type="submit">Se connecter</button>
            </div>

        </form>

    </div>

</body>
</html>
