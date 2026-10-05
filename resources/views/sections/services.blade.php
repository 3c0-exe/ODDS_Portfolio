@php
$defaultServiceNames = [
    "GAME\nDEVELOPMENT",
    "IOT\nSYSTEMS",
    "SOFTWARE\nDEVELOPMENT",
    "WEB\nDEVELOPMENT",
    "MOBILE\nAPPLICATIONS",
    "BACKEND\n& DEVOPS",
];

$items = isset($services) && count($services) > 0 
    ? $services 
    : collect($defaultServiceNames)->map(fn($n) => (object)['name' => $n]);

$formattedItems = [];
foreach ($items as $svc) {
    $raw = str_replace(["\r\n", "\r"], "\n", $svc->name ?? '');
    if (str_contains($raw, "\n")) {
        $parts = explode("\n", $raw, 2);
        $r1 = trim($parts[0]);
        $r2 = trim($parts[1]);
    } else {
        $words = preg_split('/\s+/', trim($raw));
        if (count($words) > 1) {
            $mid = (int)ceil(count($words) / 2);
            $r1 = implode(' ', array_slice($words, 0, $mid));
            $r2 = implode(' ', array_slice($words, $mid));
        } else {
            $r1 = $words[0] ?? '';
            $r2 = '';
        }
    }
    $formattedItems[] = [
        'row1' => mb_strtoupper($r1),
        'row2' => mb_strtoupper($r2),
    ];
}

$denseItems = count($formattedItems) > 0 
    ? array_merge(...array_fill(0, max(3, (int)ceil(18 / count($formattedItems))), $formattedItems))
    : $formattedItems;
@endphp

<div class="services-marquee-wrapper" id="services">
    <section class="services-marquee-strip">
    <div class="services-marquee-inner">
        {{-- Scrolling Marquee Viewport with Dual-Edge Gradient Fades --}}
        <div class="services-marquee-viewport">
            {{-- Left & Right Vignette / Gradient Fade Edges --}}
            <div class="services-fade-edge services-fade-left" aria-hidden="true"></div>
            <div class="services-fade-edge services-fade-right" aria-hidden="true"></div>

            <div class="services-marquee-track">
                {{-- Primary Group --}}
                <div class="services-marquee-group">
                    @foreach($denseItems as $item)
                        <div class="services-marquee-item">
                            <span class="services-marquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                        </div>
                        <span class="services-marquee-dot" aria-hidden="true"></span>
                    @endforeach
                </div>

                {{-- Duplicate Group for Seamless Infinite Loop --}}
                <div class="services-marquee-group" aria-hidden="true">
                    @foreach($denseItems as $item)
                        <div class="services-marquee-item">
                            <span class="services-marquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                        </div>
                        <span class="services-marquee-dot" aria-hidden="true"></span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

@php
    $catalog = require resource_path('data/service-explorer.php');
    $serviceKey = function ($service) {
        $slug = $service->slug ?: \Illuminate\Support\Str::slug($service->clean_name);
        return ['web-app-development' => 'web-development', 'hardware-solutions' => 'iot-systems', 'backend-and-devops' => 'backend-devops'][$slug] ?? $slug;
    };
    $serviceDetails = collect($catalog)->map(function ($entry, $slug) use ($services, $serviceKey) {
        $record = collect($services ?? [])->first(fn ($service) => $serviceKey($service) === $slug);
        return array_merge($entry, [
            'slug' => $slug,
            'tagline' => 'Designed with care. Built to work.',
            'icon_svg' => $record->icon_svg ?? '',
            'cover_image' => '',
            'action_btn_text' => 'Discuss your project',
            'action_btn_url' => '#contact',
            'path_str' => 'ODDS_Studio/Services/' . str_replace('-', '_', $slug),
            'body_content' => array_merge([
                ['type' => 'heading2', 'content' => 'Is this for you?'],
                ['type' => 'paragraph', 'content' => $entry['fit']],
                ['type' => 'heading2', 'content' => 'What we can build'],
            ], array_map(fn ($example) => ['type' => 'bullet', 'content' => $example], $entry['examples']), [
                ['type' => 'heading2', 'content' => 'How we start'],
                ['type' => 'paragraph', 'content' => 'We talk through what you need, agree on an approach, and put together a proposal. Scope, budget, and timing depend on your project.'],
            ]),
        ]);
    })->values();
    // Keep custom CMS services discoverable alongside the proposed core offering.
    foreach ($services ?? [] as $service) {
        if (!isset($catalog[$serviceKey($service)])) {
            $serviceDetails->push([
                'name' => $service->clean_name, 'description' => $service->description,
                'icon' => 'fa-code', 'icon_svg' => $service->icon_svg,
                'tagline' => $service->tagline, 'features' => $service->features,
                'body_content' => $service->body_content, 'cover_image' => $service->cover_image_url,
                'action_btn_text' => 'Discuss your project', 'action_btn_url' => '#contact',
                'contact' => $service->clean_name,
            ]);
        }
    }
@endphp

<section class="service-explorer" aria-labelledby="service-explorer-title">
    {{-- Left Vertical Marquee --}}
    <div class="services-vmarquee services-vmarquee-left" aria-hidden="true">
        <div class="services-vmarquee-track services-vmarquee-track-up">
            <div class="services-vmarquee-group">
                @foreach($denseItems as $item)
                    <span class="services-vmarquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                    <span class="services-vmarquee-dot"></span>
                @endforeach
            </div>
            <div class="services-vmarquee-group" aria-hidden="true">
                @foreach($denseItems as $item)
                    <span class="services-vmarquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                    <span class="services-vmarquee-dot"></span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Vertical Marquee --}}
    <div class="services-vmarquee services-vmarquee-right" aria-hidden="true">
        <div class="services-vmarquee-track services-vmarquee-track-down">
            <div class="services-vmarquee-group">
                @foreach($denseItems as $item)
                    <span class="services-vmarquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                    <span class="services-vmarquee-dot"></span>
                @endforeach
            </div>
            <div class="services-vmarquee-group" aria-hidden="true">
                @foreach($denseItems as $item)
                    <span class="services-vmarquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                    <span class="services-vmarquee-dot"></span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="service-explorer-inner">
        <div class="service-explorer-heading">
            <div>
                <p class="service-explorer-eyebrow">Services</p>
                <h2 id="service-explorer-title"><span>What You Need.</span><br><strong>Built Around You.</strong></h2>
            </div>
            <p class="service-explorer-intro">Websites, apps, custom systems, and connected hardware—shaped around the problem you're trying to solve.</p>
        </div>
        <div class="studio-desktop" id="studio-desktop" aria-label="Interactive ODDS Services desktop">
            <div class="studio-menu-bar">
                <span class="studio-menu-brand"><img src="{{ asset('assets/img/ODDS_logo.svg') }}" alt="ODDS"><span>Studio desktop</span></span>
                <time class="studio-clock" aria-label="Current time in Manila"></time>
            </div>
            <div class="studio-workspace" id="studio-workspace">
                <div class="studio-wallpaper" aria-hidden="true">
                    <svg class="studio-wallpaper-signature" viewBox="0 0 28 28" fill="currentColor">
                        <path d="M11.3567 12.2224C11.376 12.4818 11.5355 12.7099 11.7726 12.817L19.6574 16.378C20.1484 16.5998 20.6978 16.2154 20.6579 15.6782L20.2762 10.5463C20.2569 10.287 20.0974 10.0589 19.8603 9.95181L11.9755 6.39075C11.4845 6.169 10.9351 6.55335 10.975 7.09063L11.3567 12.2224Z"/>
                        <path d="M10.8914 13.253C11.0988 13.096 11.3754 13.0649 11.6124 13.172L19.4972 16.733C19.9882 16.9548 20.0631 17.6211 19.6336 17.9463L15.5312 21.053C15.3239 21.21 15.0472 21.2411 14.8102 21.1341L6.92539 17.573C6.43438 17.3512 6.35946 16.6849 6.78897 16.3597L10.8914 13.253Z"/>
                        <path d="M27.9087 13.9543C27.9087 21.6611 21.6611 27.9087 13.9543 27.9087C6.24757 27.9087 0 21.6611 0 13.9543C0 6.24757 6.24757 0 13.9543 0C21.6611 0 27.9087 6.24757 27.9087 13.9543ZM2.99795 13.9543C2.99795 20.0054 7.90329 24.9107 13.9543 24.9107C20.0054 24.9107 24.9107 20.0054 24.9107 13.9543C24.9107 7.90329 20.0054 2.99795 13.9543 2.99795C7.90329 2.99795 2.99795 7.90329 2.99795 13.9543Z"/>
                    </svg>
                </div>
                <div class="studio-shortcuts">
                    @foreach($serviceDetails as $index => $service)
                        <button type="button" class="studio-shortcut" data-studio-open="{{ $index }}" aria-controls="studio-window-{{ $index }}">
                            <span class="studio-app-icon"><i class="fa-solid {{ $service['icon'] }}" aria-hidden="true"></i><span class="studio-shortcut-arrow" aria-hidden="true">↗</span></span>
                            <span>{{ $service['name'] }}</span>
                        </button>
                    @endforeach
                </div>
                <aside class="studio-welcome-note studio-lorenzo-terminal" aria-label="Lorenzo front desk terminal">
                    <div class="studio-welcome-titlebar"><span class="studio-terminal-dots" aria-hidden="true"><i></i><i></i><i></i></span><span>lorenzo — front desk</span></div>
                    <div class="studio-welcome-content">
                        <p class="studio-terminal-prompt"><span>lorenzo@odds</span>:~$ welcome</p>
                        <h3>Welcome to the studio.</h3>
                        <p>Open a service to see what we can build.</p>
                        <button type="button" data-studio-chat><span class="studio-terminal-command">&gt; chat with Lorenzo</span><span class="studio-terminal-cursor" aria-hidden="true">▌</span></button>
                    </div>
                </aside>
                <div class="studio-window-layer" id="studio-window-layer"></div>
                <p class="studio-desktop-hint"><span aria-hidden="true">↖</span> Open a service. See what we can build.</p>
            </div>
            <div class="studio-taskbar">
                <button type="button" class="studio-launcher-button" id="studio-launcher-button" aria-expanded="false" aria-controls="studio-launcher">ODDS</button>
                <div class="studio-dock" aria-label="Service applications">
                    @foreach($serviceDetails as $index => $service)
                        <button type="button" class="studio-dock-app" data-studio-open="{{ $index }}" title="{{ $service['name'] }}" aria-label="Open {{ $service['name'] }}"><i class="fa-solid {{ $service['icon'] }}" aria-hidden="true"></i><span class="studio-running-dot"></span></button>
                    @endforeach
                </div>
                <button type="button" class="studio-show-desktop" id="studio-show-desktop" title="Minimize all windows" aria-label="Show desktop"><i class="fa-regular fa-window-restore" aria-hidden="true"></i></button>
            </div>
            <div class="studio-launcher" id="studio-launcher" hidden>
                <p>What are we building?</p>
                @foreach($serviceDetails as $index => $service)
                    <button type="button" data-studio-open="{{ $index }}"><i class="fa-solid {{ $service['icon'] }}" aria-hidden="true"></i>{{ $service['name'] }}</button>
                @endforeach
            </div>
        </div>
        <button type="button" class="studio-list-toggle" id="studio-list-toggle" aria-expanded="false" aria-controls="studio-service-list">Prefer a simple list? <span>View all services ↗</span></button>
        <div class="service-explorer-grid" id="studio-service-list" hidden>
            @foreach($serviceDetails as $index => $service)
                <button type="button" class="service-explorer-card service-card-trigger" data-service-index="{{ $index }}" aria-haspopup="dialog" aria-controls="service-modal">
                    <span class="service-explorer-card-top"><span class="service-explorer-number">{{ sprintf('%02d', $index + 1) }}</span><i class="fa-solid {{ $service['icon'] }}" aria-hidden="true"></i></span>
                    <span class="service-explorer-name">{{ $service['name'] }}</span>
                    <span class="service-explorer-description">{{ $service['description'] }}</span>
                    <span class="service-explorer-action">Explore service <span aria-hidden="true">↗</span></span>
                </button>
            @endforeach
        </div>
        <div class="service-explorer-footer">
            <p>Not sure where your idea fits? <span>That's a good place to start.</span></p>
            <a href="#contact" class="js-open-contact-modal" data-open-contact>Let's figure it out <span aria-hidden="true">↗</span></a>
        </div>
    </div>
</section>

{{-- Bottom Services Marquee Strip --}}
<div class="services-marquee-wrapper services-marquee-bottom-wrapper">
    <section class="services-marquee-strip">
        <div class="services-marquee-inner">
            {{-- Scrolling Marquee Viewport with Dual-Edge Gradient Fades --}}
            <div class="services-marquee-viewport">
                {{-- Left & Right Vignette / Gradient Fade Edges --}}
                <div class="services-fade-edge services-fade-left" aria-hidden="true"></div>
                <div class="services-fade-edge services-fade-right" aria-hidden="true"></div>

                <div class="services-marquee-track services-marquee-track-reverse">
                    {{-- Primary Group --}}
                    <div class="services-marquee-group">
                        @foreach($denseItems as $item)
                            <div class="services-marquee-item">
                                <span class="services-marquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                            </div>
                            <span class="services-marquee-dot" aria-hidden="true"></span>
                        @endforeach
                    </div>

                    {{-- Duplicate Group for Seamless Infinite Loop --}}
                    <div class="services-marquee-group" aria-hidden="true">
                        @foreach($denseItems as $item)
                            <div class="services-marquee-item">
                                <span class="services-marquee-text">{{ $item['row1'] }}{{ !empty($item['row2']) ? ' ' . $item['row2'] : '' }}</span>
                            </div>
                            <span class="services-marquee-dot" aria-hidden="true"></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="application/json" id="odds-services-data">{!! json_encode($serviceDetails, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@push('modals')
    @include('components.service-modal')
@endpush
