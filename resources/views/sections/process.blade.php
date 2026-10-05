@php
$processPhases = [
    [
        'number' => '01',
        'sequencing' => 'First',
        'eyebrow' => 'DISCOVERY + PROPOSAL',
        'headline' => 'Talk & Plan',
        'body' => 'We start with a 1-on-1 to understand what you need, what you already know, your current process, and your tech stack preference — or you can leave that decision to us. From there, we put together a draft and come back with a clear proposal covering scope and approach.',
        'image' => asset('assets/img/process/phase-01-discovery.jpg'),
        'alt' => 'ODDS Discovery & Planning Session with Client',
        'theme' => 'pink',
        // Chat/conversation prompt icon (Terminal prompt query / message bubble mark)
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/><path d="M9.5 9h.01"/><path d="M12 12h.01"/><path d="M14.5 9h.01"/></svg>',
    ],
    [
        'number' => '02',
        'sequencing' => 'Then',
        'eyebrow' => 'EXECUTION + CHECK-INS',
        'headline' => 'Build',
        'body' => 'Once aligned, we execute — velocity-driven, no bloated planning loops. Regular check-ins happen throughout so nothing drifts and you always know where things stand.',
        'image' => asset('assets/img/process/phase-02-build.jpg'),
        'alt' => 'Active High-Velocity Software Engineering Workspace',
        'theme' => 'purple',
        // Terminal / code execution mark (<_ prompt cursor motif)
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>',
    ],
    [
        'number' => '03',
        'sequencing' => 'Finally',
        'eyebrow' => 'DELIVERY + OWNERSHIP',
        'headline' => 'Launch & Handoff',
        'body' => 'We ship, and hand over what\'s needed — code, docs, ownership.',
        'image' => asset('assets/img/process/phase-03-launch.jpg'),
        'alt' => 'Product Launch Deployment and Client Handoff',
        'theme' => 'cyan',
        // Terminal deploy / completion mark ([✓] bracketed checkmark motif)
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4H4a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h2"/><path d="M18 4h2a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-2"/><polyline points="8.5 12.5 11 15 16 9"/></svg>',
    ],
];
@endphp

<section class="process" id="process">
    {{-- Ambient tech grid pattern & light background orbs --}}
    <div class="process-grid-pattern" aria-hidden="true"></div>
    <div class="process-orb process-orb-1" aria-hidden="true"></div>
    <div class="process-orb process-orb-2" aria-hidden="true"></div>

    <div class="process-content-wrap">
        {{-- Section Header --}}
        <div class="process-center">
            <p class="process-label fade-up">Our Process</p>
            <h2 class="process-title fade-up">
                How We Take You From Zero to Shipped.
            </h2>
            <p class="process-desc fade-up">
                A streamlined, battle-tested execution pipeline with zero wasted motion. Built on real internal agility, not generic agency bureaucracy.
            </p>
        </div>

        {{-- Background Connecting Line Path SVG --}}
        <div class="process-linepath-wrap" aria-hidden="true">
            <svg class="process-linepath-svg" viewBox="0 0 565 925" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="process-content-fade">
                        <stop offset="0" stop-color="white" />
                        <stop offset="0.022" stop-color="black" />
                        <stop offset="0.978" stop-color="black" />
                        <stop offset="1" stop-color="white" />
                    </linearGradient>
                    <mask id="process-content-mask" maskUnits="userSpaceOnUse" x="-20000" y="-20000" width="40000" height="40000" style="mask-type: luminance">
                        <rect x="-20000" y="-20000" width="40000" height="40000" fill="white" />
                        <rect id="process-content-cutout" x="0" y="-100" width="0" height="300" fill="black" />
                    </mask>
                </defs>
                <path id="process-line-path" class="process-line-path" mask="url(#process-content-mask)" d="M -2400 24 L 380 24 C 450 24 472 42 467.332 65.742 C 454.431 127.953 404.689 176.83 342.376 182.085 L 114.38 201.314 C 89.7562 203.391 66.5806 213.818 48.6935 230.868 C -13.312 289.973 14.502 394.256 97.7059 414.631 L 505.918 514.595 C 512.476 516.201 518.697 518.955 524.295 522.729 C 573.667 556.018 545.675 633.188 486.442 627.082 L 127.407 590.071 C 108.352 588.107 89.2368 593.184 73.668 604.345 C 11.7091 648.76 43.1302 746.523 119.364 746.523 H 150.72 C 201.364 746.523 241.681 788.937 239.117 839.515 L 234.832 924.023" stroke="#FF7E5D" stroke-width="30" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="process-flow-path" class="process-line-path" d="M 380 24 C 450 24 472 42 467.332 65.742 C 454.431 127.953 404.689 176.83 342.376 182.085 L 114.38 201.314 C 89.7562 203.391 66.5806 213.818 48.6935 230.868 C -13.312 289.973 14.502 394.256 97.7059 414.631 L 505.918 514.595 C 512.476 516.201 518.697 518.955 524.295 522.729 C 573.667 556.018 545.675 633.188 486.442 627.082 L 127.407 590.071 C 108.352 588.107 89.2368 593.184 73.668 604.345 C 11.7091 648.76 43.1302 746.523 119.364 746.523 H 150.72 C 201.364 746.523 241.681 788.937 239.117 839.515 L 234.832 924.023" pathLength="1" stroke="#FF7E5D" stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="1 1" stroke-dashoffset="1" style="opacity: 0" />
            </svg>
        </div>


        {{-- Editorial Zigzag Sequence (3 Phases) --}}
        <div class="process-editorial-feed">

            @foreach($processPhases as $idx => $phase)
            @php
                $isFlipped = ($idx % 2 === 1);
            @endphp
            <div class="process-phase-block fade-up {{ $isFlipped ? 'is-flipped' : '' }} phase-{{ $phase['number'] }}" data-phase="{{ $phase['number'] }}">
                
                {{-- Text Content Side --}}
                <div class="process-phase-content-side">
                    <div class="process-phase-text-body">
                        {{-- Custom Icon + Sequencing Cue Group (First / Then / Finally) --}}
                        <div class="process-phase-lead-wrap">
                            <span class="process-phase-icon" aria-hidden="true">
                                {!! $phase['icon'] !!}
                            </span>
                            <span class="process-phase-sequencing">{{ $phase['sequencing'] }}</span>
                        </div>

                        {{-- Phase Headline --}}
                        <h3 class="process-phase-headline">{{ $phase['headline'] }}</h3>

                        {{-- Phase Body Copy --}}
                        <p class="process-phase-body-text">{{ $phase['body'] }}</p>
                    </div>
                </div>

                {{-- Visual Image Side (Rounded Square/Portrait Editorial Image) --}}
                <div class="process-phase-media-side">
                    <div class="process-image-frame">
                        <div class="process-image-glow" aria-hidden="true"></div>
                        <picture style="display: block; width: 100%; height: 100%;">
                            <source srcset="{{ \Illuminate\Support\Str::replaceLast('.jpg', '.webp', $phase['image']) }}" type="image/webp">
                            <img src="{{ $phase['image'] }}" alt="{{ $phase['alt'] }}" class="process-editorial-img" loading="lazy" decoding="async" width="1200" height="896">
                        </picture>
                        <div class="process-image-tint" aria-hidden="true"></div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Bottom CTA Action --}}
        <div class="process-footer fade-up">
            <a href="#cta" class="works-see-more">
                Let's Get Started
            </a>
        </div>
    </div>
</section>
