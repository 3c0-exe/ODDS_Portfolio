<section class="who-we-are" id="who-we-are">
    <div class="who-we-are-inner">
        {{-- Left Content Column with Dotted Grid Pattern --}}
        <div class="who-we-are-left">
            <div class="who-we-are-dots" aria-hidden="true"></div>
            <div class="who-we-are-content">
                <p class="who-we-are-label fade-up">— Who we are</p>
                <div class="who-we-are-mobile-media fade-up" aria-hidden="false">
                    <img src="{{ !empty($settings->who_we_are_image) ? $settings->who_we_are_image : asset('storage/odds/whoweare/ODDS_founder_grouppic_noframe.png') }}"
                         alt="ODDS Founders Team"
                         class="who-we-are-mobile-img"
                         loading="lazy"
                         decoding="async">
                </div>
                <h2 class="who-we-are-statement who-we-are-heading fade-up">
                    <span class="who-we-are-text-dark">The partners you bring in<br class="hidden lg:inline"> when getting it right isn't optional.<br class="hidden lg:inline"></span>
                    <span class="who-we-are-text-muted">We strip away the noise and<br class="hidden lg:inline"> overcomplicated processes to build clean, intuitive products that<br class="hidden lg:inline"></span>
                    <strong class="who-we-are-text-bold">solve real-world problems.</strong>
                </h2>
                <div class="who-we-are-action fade-up">
                    <a href="{{ route('portfolio.about') }}" class="who-we-are-btn" id="who-we-are-btn" aria-label="Learn how we work in About Us">
                        <span>How we work</span>
                        <svg class="who-we-are-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2.5 8H13.5M13.5 8L8.5 3M13.5 8L8.5 13" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Right Column with Framed Founders Group Photograph --}}
        <div class="who-we-are-right">
            <div class="who-we-are-ambient-bg" aria-hidden="true" style="background-image: url('{{ !empty($settings->who_we_are_image) ? $settings->who_we_are_image : asset('storage/odds/whoweare/ODDS_founder_grouppic_noframe.png') }}');"></div>
            <div class="who-we-are-frame">
                <img src="{{ !empty($settings->who_we_are_image) ? $settings->who_we_are_image : asset('storage/odds/whoweare/ODDS_founder_grouppic_noframe.png') }}"
                     alt="ODDS Founders Team"
                     class="who-we-are-img"
                     loading="lazy"
                     decoding="async">
            </div>
        </div>
    </div>
</section>
