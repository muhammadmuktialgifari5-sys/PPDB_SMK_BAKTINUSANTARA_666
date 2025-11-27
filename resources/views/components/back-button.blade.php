@props(['url' => null, 'text' => 'Kembali', 'fallback' => '/'])

<div class="mb-6">
    @if($url)
        <a href="{{ $url }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ $text }}
        </a>
    @else
        <button onclick="goBack()" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ $text }}
        </button>
        <script>
        function goBack() {
            if (document.referrer && document.referrer !== window.location.href) {
                window.history.back();
            } else {
                window.location.href = '{{ $fallback }}';
            }
        }
        </script>
    @endif
</div>