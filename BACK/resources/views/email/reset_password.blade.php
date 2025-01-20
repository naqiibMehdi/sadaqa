<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 30px;
        }

        .button {
            background-color: #007bff;
            color: #fff;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .email-footer {
            font-size: 14px;
            color: #aaa;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div style="text-align: center;">
        <!-- Logo -->
        <img src="{{ asset('storage/logo.svg') }}" alt="Logo de l'association"
             style="max-width: 200px; margin-bottom: 20px;">
    </div>
    <div class="email-header">
        <h2>Réinitialisation de votre mot de passe</h2>
    </div>

    <div class="email-body">
        <p>Bonjour,</p>
        <p>Nous avons reçu une demande de réinitialisation de votre mot de passe. Si vous n'êtes pas à l'origine de
            cette demande, vous pouvez ignorer ce message.</p>
        <p>Pour réinitialiser votre mot de passe, cliquez sur le bouton ci-dessous :</p>

        <a href="{{ $urlToken }}" class="button">Réinitialiser mon mot de passe</a>
    </div>

    <div class="email-footer">
        <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        <p>Merci, l'équipe {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
