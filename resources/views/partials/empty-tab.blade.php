@php
    $iconColor = match ($icon ?? '') {
        'mdi:cash-clock' => 'text-amber-300',
        'mdi:cog-outline' => 'text-blue-300',
        'mdi:truck-outline' => 'text-indigo-300',
        'mdi:check-decagram-outline' => 'text-emerald-300',
        'mdi:check-circle-outline' => 'text-teal-300',
        'mdi:alpha-x-circle-outline' => 'text-red-300',
        default => 'text-gray-300',
    };
@endphp

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <span class="iconify {{ $iconColor }}" data-icon="{{ $icon ?? 'mdi:clipboard-text-outline' }}"
                data-width="40" data-height="40">
            </span>
        </div>
        <p class="text-gray-400 text-sm">{{ $label ?? 'Tidak ada data' }}</p>
    </div>
</div>