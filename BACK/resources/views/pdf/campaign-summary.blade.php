<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Récapitulatif - {{ $campaignRecovery->campaign->title }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.4;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 20px;
    }

    .campaign-info {
      margin-bottom: 30px;
    }

    .details {
      margin-top: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
<div class="header">
  <h1>Récapitulatif de la cagnotte</h1>
  <h2>Facture pour la cagnotte : {{ $campaignRecovery->campaign->title }}</h2>
</div>

<div class="campaign-info">
  <p><strong>Créé(e) par :</strong> {{ $campaignRecovery->user->name }}</p>
  <p><strong>Date de création de la cagnotte:</strong> {{ $campaignRecovery->campaign->created_at->format('d/m/Y') }}
  <p><strong>Date de la demande de virement:</strong> {{ $campaignRecovery->created_at->format('d/m/Y') }}
  </p>
</div>

<div class="details">
  <h3>Détails de la facture</h3>
  <table>
    <thead>
    <tr>
      <th>Montant avant déduction</th>
      <th>Part de 2.5% pour l'association</th>
      <th>Total après déduction</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>{{ $campaignRecovery->amount / 100 }} €</td>
      <td>{{ round(($campaignRecovery->amount * 0.025) / 100, 2) }} €</td>
      <td>{{ round(($campaignRecovery->amount * 0.975) / 100, 2) }} €</td>
    </tr>
    </tbody>
  </table>
  <p>Ce montant sera viré sur votre compte dans un délais de 4 à 5 jours ouvrés.</p>
</div>
</body>
</html>
