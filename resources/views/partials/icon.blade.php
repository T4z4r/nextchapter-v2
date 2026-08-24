@php($icons = [
    'database' => '<path d="M4 7c0-1.7 3.6-3 8-3s8 1.3 8 3-3.6 3-8 3-8-1.3-8-3z"/><path d="M4 7v10c0 1.7 3.6 3 8 3s8-1.3 8-3V7" stroke-linecap="round"/><path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>',
    'document' => '<path d="M7 3h7l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z"/><path d="M14 3v5h5" stroke-linejoin="round"/><path d="M9 13h6M9 17h6" stroke-linecap="round"/>',
    'shield' => '<path d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" stroke-linejoin="round"/>',
    'scales' => '<path d="M16 8l7 12H9z" transform="translate(-9,-2)" stroke-linejoin="round"/><path d="M4 22h24" transform="translate(-2,-2)" stroke-linecap="round"/>',
    'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>',
    'chart' => '<path d="M6 9l6-6 6 6M12 3v12M6 21h12" stroke-linecap="round" stroke-linejoin="round"/>',
    'check' => '<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>',
])
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">{!! $icons[$name] ?? $icons['check'] !!}</svg>
