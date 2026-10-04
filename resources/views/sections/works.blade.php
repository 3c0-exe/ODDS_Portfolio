@php
$workItems = isset($works) && count($works) > 0 ? $works : collect([
    (object)['title' => 'Liberty',      'category' => 'Web & CMS',          'year' => '2023', 'description' => 'Corporate security agency website for Liberty Investigation & Security Agency Inc.'],
    (object)['title' => 'SPCC Website', 'category' => 'Web Development',    'year' => '2023', 'description' => 'Modern institutional web portal for Systems Plus Computer College.'],
    (object)['title' => 'AVONIC',       'category' => 'Hardware & IoT',     'year' => '2023', 'description' => 'IoT vermicompost monitor with soil moisture, gas, temperature, and humidity sensors.'],
    (object)['title' => 'MoneySense',   'category' => 'Mobile App',         'year' => '2022', 'description' => 'Philippine currency recognition app with bill scanning and denomination tracking.'],
    (object)['title' => 'SIBOL',        'category' => 'IoT & AgriTech',     'year' => '2023', 'description' => 'Smart farming IoT platform with real-time crop and environmental monitoring.'],
    (object)['title' => 'THEODORE',     'category' => 'Security & Vision',  'year' => '2024', 'description' => 'AI-powered CCTV fire detection and remote camera control system.'],
    (object)['title' => 'HALLET',       'category' => 'Mobile App',         'year' => '2023', 'description' => 'Personal finance mobile app with multi-wallet, transaction tracking, and spending analytics.'],
    (object)['title' => 'LITIKS',       'category' => 'Analytics Platform', 'year' => '2024', 'description' => 'Multi-branch sales analytics, forecasting, and customer segmentation SaaS.'],
    (object)['title' => 'TRYSEN',       'category' => 'Security & Systems', 'year' => '2024', 'description' => 'Facial recognition attendance system with secure campus access control.'],
]);
@endphp

<section class="works" id="works">
  <div class="works-content-wrap">

    {{-- Section label --}}
    <p class="works-section-label animate-fade-up fade-up" style="animation-delay: 50ms;">Our Works</p>

    {{-- Main heading --}}
    <h2 class="works-heading animate-fade-up fade-up" style="animation-delay: 100ms;">
      <span class="works-heading-lead">We Don't Just Build.</span><br>
      <span class="works-heading-deliver">We Deliver.</span>
    </h2>



    {{-- Description --}}
    <p class="works-description animate-fade-up fade-up" style="animation-delay: 200ms;">
      Real-world solutions, custom-engineered for rapid deployment and measurable business impact.
    </p>

    {{-- 3×3 Folder Card Grid --}}
    <div class="works-card-grid">

      @foreach($workItems as $index => $item)
      @php 
        $rowNum = floor($index / 3) + 1;
        $delayClass = "delay-row-{$rowNum}";
      @endphp
      <div class="project-card-trigger works-folder-card group relative drop-shadow-2xl
                  transition-transform duration-150 ease-out active:scale-[0.97] active:drop-shadow-lg
                  animate-fade-up {{ $delayClass }}"
           data-project-index="{{ $index }}"
           data-project-id="{{ $item->id ?? $index }}"
           data-project-title="{{ $item->title }}"
           data-project-category="{{ $item->category ?? 'Software Architecture' }}"
           data-project-year="{{ $item->year ?? '2024' }}"
           data-project-desc="{{ $item->description ?? '' }}"
           data-project-cover="{{ $item->cover_image_url ?? ($item->cover_image ?? '') }}"
           data-project-video="{{ $item->showcase_video_url ?? ($item->showcase_video ?? '') }}"
           data-project-demo="{{ $item->demo_url ?? '' }}"
           data-project-github="{{ $item->github_url ?? '' }}"
           data-project-path="ODDS_Project/{{ Str::studly($item->title) }}/Project_Story">
        <div class="sync-ease absolute top-[1px] right-0 h-[31px] z-20 origin-right
                    w-[150px] sm:w-[190px] md:w-[200px] md:group-hover:w-[225px]
                    bg-[#2b2b2b] text-white rounded-full font-semibold text-[10px] sm:text-[11px] tracking-widest border border-[#1a1a1a]
                    flex items-center justify-center shadow-md transition-all px-2.5
                    group-hover:bg-black group-hover:border-white/30 group-hover:shadow-lg">
          <span class="sync-ease whitespace-nowrap overflow-hidden text-ellipsis transition-transform">{{ $item->title }}</span>
        </div>
        <div class="absolute inset-0">
          <svg class="w-full h-full block overflow-visible" viewBox="-1 -1 408 248" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <clipPath id="folder-clip-{{ $item->id ?? $index }}">
                <path class="morph-path" d="M182.5 0C192.717 0 201 8.28273 201 18.5C201 28.7173 209.283 37 219.5 37H396C401.523 37 406 41.4772 406 47V236C406 241.523 401.523 246 396 246H10C4.47715 246 0 241.523 0 236V10C0 4.47716 4.47715 0 10 0H182.5Z" />
              </clipPath>
            </defs>

            <!-- Base Gray Folder Body Background -->
            <path class="morph-path group-hover:fill-[#d8d8d8]" fill="#CCCCCC" />

            @php $coverSrc = $item->cover_image_url ?? ($item->cover_image ?? null); @endphp
            @if(!empty($coverSrc))
            <!-- Clipped 16:9 Image Body from Admin -->
            <g clip-path="url(#folder-clip-{{ $item->id ?? $index }})">
              <foreignObject x="0" y="0" width="406" height="246" class="transition-transform duration-300 ease-out group-hover:scale-105 origin-center">
                <img xmlns="http://www.w3.org/1999/xhtml" src="{{ $coverSrc }}" alt="{{ $item->title }} preview" loading="lazy" decoding="async" width="406" height="246" style="display: block; width: 100%; height: 100%; object-fit: cover;">
              </foreignObject>
              <rect x="0" y="0" width="406" height="246" fill="#000000" class="opacity-10 group-hover:opacity-0 transition-opacity duration-300 pointer-events-none" />
            </g>
            @endif

            <!-- Clean Outline Stroke -->
            <path class="morph-path" fill="none" stroke="#262626" stroke-width="1" vector-effect="non-scaling-stroke" />
          </svg>
        </div>

        @if(empty($coverSrc))
        <div class="absolute inset-0 z-10 flex items-center justify-center p-6 pt-10 pointer-events-none">
          <div class="sync-ease flex items-center justify-center group-hover:scale-105">
            <svg width="99" height="99" viewBox="0 0 99 99" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.2" class="transition-opacity duration-300 group-hover:opacity-40">
                <path d="M15.6914 92.692C13.0445 92.692 10.7795 91.7503 8.89616 89.8671C7.01287 87.9838 6.06961 85.7171 6.06641 83.067V15.6919C6.06641 13.045 7.00966 10.7799 8.89616 8.89665C10.7827 7.01335 13.0477 6.0701 15.6914 6.06689H83.0665C85.7134 6.06689 87.9801 7.01015 89.8666 8.89665C91.7531 10.7831 92.6947 13.0482 92.6915 15.6919V83.067C92.6915 85.7139 91.7499 87.9805 89.8666 89.8671C87.9833 91.7535 85.7166 92.6952 83.0665 92.692H15.6914ZM15.6914 83.067H83.0665V15.6919H15.6914V83.067ZM20.5039 73.442H78.254L60.2071 49.3794L45.7696 68.6295L34.9414 54.1919L20.5039 73.442Z" fill="black" />
              </g>
            </svg>
          </div>
        </div>
        @endif
      </div>
      @endforeach

    </div><!-- end grid -->

    {{-- See More button --}}
    <a href="{{ route('portfolio.our-work') }}" class="works-see-more animate-fade-up fade-up" style="animation-delay: 950ms;">
      See More
    </a>

  </div>
</section>

{{-- High-fidelity JSON Data Payload for Modal Stories --}}
<script type="application/json" id="odds-projects-data">
{!! json_encode($workItems->map(function($item, $idx) {
    $rawBlocks = $item->body_content ?? [];
    if (is_string($rawBlocks)) {
        $decoded = json_decode($rawBlocks, true);
        $rawBlocks = is_array($decoded) ? $decoded : [];
    }
    return [
        'id' => $item->id ?? ($idx + 1),
        'title' => $item->title ?? 'ODDS Project',
        'category' => $item->category ?? 'Software Architecture',
        'year' => $item->year ?? '2024',
        'client' => $item->client ?? '',
        'role' => $item->role ?? '',
        'description' => $item->description ?? '',
        'story_content' => $item->story_content ?? '',
        'body_content' => $rawBlocks,
        'cover_image' => $item->cover_image_url ?? $item->cover_image ?? '',
        'showcase_video' => $item->showcase_video_url ?? $item->showcase_video ?? '',
        'demo_url' => $item->demo_url ?? '',
        'github_url' => $item->github_url ?? '',
        'path_str' => 'ODDS_Project/' . \Illuminate\Support\Str::studly($item->title ?? 'Project') . '/Project_Story',
    ];
})->values()) !!}
</script>

{{-- Project Detail Modal --}}
@include('components.project-modal')
