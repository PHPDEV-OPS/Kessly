<div {{ $attributes->merge(['class' => 'flex items-center justify-center p-4']) }}>
    <div class="loading-spinner w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full"></div>
    <span class="ml-2 text-sm text-gray-600">{{ $message ?? 'Loading...' }}</span>
</div>