@props(['port', 'isUsed'])

@php
    $badgeColorClass = $isUsed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600';
    $badgeText = $isUsed ? 'Used' : 'Available';
@endphp

<div>
    <span class="badge {{ $badgeColorClass }}">{{ $badgeText }}</span>
    {{ $port->name }}
</div>
