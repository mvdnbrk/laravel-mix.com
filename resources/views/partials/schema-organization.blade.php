<script type="application/ld+json">
@php
echo json_encode([
    '@context' => 'http://schema.org/',
    '@type' => 'Organization',
    'name' => 'Laravel Mix',
    'logo' => 'https://laravel-mix.com/images/logo.png',
    'sameAs' => [
        'https://github.com/JeffreyWay/laravel-mix',
    ],
    'url' => 'https://laravel-mix.com',
], JSON_UNESCAPED_SLASHES);
@endphp
</script>
