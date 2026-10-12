<section class="who-we-are" id="who-we-are">
    @php
$teamMembers = \App\Support\OddsTeam::members();
@endphp
    <div class="who-we-are-inner">
        {{-- Text Content with Dotted Grid Pattern --}}
        <div class="who-we-are-left">
            <div class="who-we-are-dots" aria-hidden="true"></div>
            <div class="who-we-are-content">
                <p class="who-we-are-label fade-up">— Who we are</p>
                <h2 class="who-we-are-statement who-we-are-heading fade-up">
                    <span class="who-we-are-text-dark">The partners you bring in when getting it right isn't optional.</span>
                    <span class="who-we-are-text-muted">We strip away the noise and overcomplicated processes to build clean, intuitive products that</span>
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
        <aside class="who-we-are-team" aria-label="Meet the eight people behind ODDS">
            <div class="who-we-are-team-grid">
                @foreach($teamMembers as $member)
                    <a class="who-we-are-member" href="{{ route('portfolio.about') }}#meet-the-team" aria-label="Meet {{ $member['name'] }} on our About Us page">
                        <div class="who-we-are-bot-frame">
                            <img src="{{ $member['pfp'] }}" alt="" width="112" height="112" loading="lazy" decoding="async">
                        </div>
                        <span>{{ explode(' ', $member['name'])[0] }}</span>
                    </a>
                @endforeach
            </div>
            <a class="who-we-are-team-link" href="{{ route('portfolio.about') }}#meet-the-team">Eight people. One team. <span aria-hidden="true">↗</span></a>
        </aside>
    </div>
</section>
