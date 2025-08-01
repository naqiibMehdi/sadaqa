<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sadaqa - Création de compte</title>
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
    <h2>Inscription sur notre site</h2>
  </div>

  <div class="email-body">
    <p>Bonjour, et bienvenue sur le site Sadaqa.fr</p>
    <p>Nous sommes ravi de vous compter parmi nos membres. En ayant créer votre compte, vous aurez accès à plusieurs
      fonctions.</p>
    <p>Vous allez pouvoir créer des cagnottes, gérer vos informations personnelles, effectuer des demande de virement et
      télécharger vos factures.</p>

    <a href="https://saddaqa.fr/account" target="_blank" class="button">J'accède à mon profile</a>
  </div>

  <div class="email-footer">
    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
    <p>Merci, l'équipe {{ config('app.name') }}</p>
  </div>
</div>
</body>
</html>
