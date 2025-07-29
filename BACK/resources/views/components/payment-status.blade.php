@php
  $statusLabels = [
            'pending' => ["label" => "En attente", "bgcolor" => "bg-blue-100"],
            'completed' =>  ["label" => "Complété", "bgcolor" => "bg-green-100"],
            'failed' =>  ["label" => "Échoué", "bgcolor" => "bg-red-100"],
            'refunded' =>  ["label" => "Remboursé", "bgcolor" => "bg-yellow-100"],
            'cancelled' => ["label" => "Annulé", "bgcolor" => "bg-red-100"],
            // Ajoutez d'autres statuts et leurs traductions ici
        ];
@endphp

@props(["status"])

<span
  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-black-500 {{$statusLabels[$status]["bgcolor"]}}">
  {{ $statusLabels[$status]["label"] }}
</span>
