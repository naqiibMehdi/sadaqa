<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payement stripe</title>
</head>
<body>
<h1>Bonjour {{ ucwords($data["names"]) }}, voici ci-dessous le résumé de votre payement</h1>
<p>Cagnotte concernée: {{ strtoupper($data["title_campaign"]) }}</p>
<p>Montant payé: <strong>{{ number_format($data["amount"] / 100, 2, ",", " ") }} €</strong></p>

</body>
</html>
