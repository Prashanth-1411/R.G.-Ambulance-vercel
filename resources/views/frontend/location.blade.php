<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow" />
    <meta name="google-site-verification" content="xxxxx" />

    @php
        $displayName = $area?->name ?? ucwords(str_replace('-', ' ', $slug));
        $pageTitle = $area?->meta_title ?? "Ambulance Service in $displayName | R.G. Ambulance Service";
        $pageDesc = $area?->meta_description ?? "24/7 emergency ambulance service in $displayName, Chennai. ICU, ventilator, BLS, ALS ambulances with rapid response. Call +91 95516 63530.";
        $canonical = url("/ambulance-service-in-$slug");
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}" />
    <link rel="canonical" href="{{ $canonical }}" />
    <link rel="sitemap" type="application/xml" href="/sitemap.xml" />
    <link rel="icon" type="image/png" href="/frontend/Favicon.png" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:title" content="{{ $pageTitle }}" />
    <meta property="og:description" content="{{ $pageDesc }}" />
    <meta property="og:locale" content="en_IN" />
    <meta property="og:site_name" content="R.G. Ambulance Service" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $pageTitle }}" />
    <meta name="twitter:description" content="{{ $pageDesc }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="/frontend/assets/index-CA_gLn4R.css" />
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div id="root">
        <!-- Server-rendered fallback content for crawlers (React replaces this on load) -->
        <div style="padding: 120px 20px 60px; max-width: 1200px; margin: 0 auto; font-family: system-ui, sans-serif;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #0a1628; margin-bottom: 0.5rem;">
                Ambulance Service in {{ $displayName }}
            </h1>
            <p style="font-size: 1rem; color: #475569; line-height: 1.6; max-width: 800px;">
                @if($area && $area->description)
                    {{ $area->description }}
                @else
                    24/7 emergency ICU and ventilator ambulance services in {{ $displayName }}, Chennai. Call +91 95516 63530 for immediate dispatch.
                @endif
            </p>
            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="tel:+919551663530" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #DC2626; color: white; font-weight: 700; border-radius: 12px; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-phone"></i> Call Now: +91 95516 63530
                </a>
                <a href="https://wa.me/918778481556" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #25D366; color: white; font-weight: 700; border-radius: 12px; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-comment"></i> WhatsApp Dispatch
                </a>
            </div>
        </div>
    </div>
    <script type="module" src="/frontend/assets/index-BEhiThSs.js"></script>
    <!-- JSON-LD for local business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EmergencyService",
      "name": "R.G. Ambulance Service - {{ $displayName }}",
      "url": "{{ $canonical }}",
      "description": "{{ $pageDesc }}",
      "telephone": "+919551663530",
      "areaServed": {
        "@type": "City",
        "name": "{{ $displayName }}",
        "addressLocality": "{{ $displayName }}",
        "addressRegion": "Tamil Nadu",
        "addressCountry": "IN"
      },
      "openingHours": "Mo-Su 00:00-23:59"
    }
    </script>
</body>
</html>
