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
    <h2>Suppression de votre compte</h2>
  </div>

  <div class="email-body">
    <p>Bonjour, votre compte a bien été supprimé.</p>
    <p>Votre compte personnel ainsi que vos cagnottes ont bien été supprimés. Seuls les dons liés à vos cagnottes et vos
      demandes de virements ont été conservés pour des raisons juridiques et financières. Ces données financières seront
      conservées selon la loi financière française.</p>
  </div>

  <div class="email-footer">
    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
    <p>Merci, l'équipe {{ config('app.name') }}</p>
  </div>
</div>
</body>
</html>
