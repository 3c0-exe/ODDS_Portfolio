<?php

return [
    'url' => env('SEO_PUBLIC_URL', env('APP_URL', 'https://www.oddsstudio.site')),
    'site_name' => 'ODDS Studio',
    'image' => '/assets/img/odds-social.png',
    'image_alt' => "ODDS Studio — Let's build something real. Custom websites, apps, software, and connected hardware.",
    'pages' => [
        'portfolio.index' => [
            'title' => "ODDS Studio — Let's Build Something Real.",
            'description' => 'Custom websites, mobile apps, software, and connected hardware. Explore what ODDS builds and tell us what you need.',
        ],
        'portfolio.about' => [
            'title' => 'About ODDS — Our Team & Studio',
            'description' => 'Meet the people behind ODDS Studio, explore our story, and learn how we approach design, development, and working together.',
        ],
        'portfolio.our-work' => [
            'title' => 'Our Work — ODDS Studio',
            'description' => 'Explore ODDS projects across web development, mobile applications, custom software, and connected hardware.',
        ],
        'portfolio.faqs' => [
            'title' => 'FAQs — Working With ODDS',
            'description' => 'Answers to questions about working with ODDS: project scope, pricing, development, delivery, and ownership.',
        ],
    ],
];
