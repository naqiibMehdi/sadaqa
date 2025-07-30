@php
  $statusLabels = [
            'pending' => ["label" => "En attente", "bgcolor" => "bg-blue-100"],
            'processed' =>  ["label" => "Complété", "bgcolor" => "bg-green-100"],
            'failed' =>  ["label" => "Échoué", "bgcolor" => "bg-red-100"],
        ];
@endphp

@props(["status"])

<span
  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-black-500 {{$statusLabels[$status]["bgcolor"]}}">
  {{ $statusLabels[$status]["label"] }}
</span>
