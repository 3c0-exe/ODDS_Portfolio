<x-layout>
    {{-- Hero Section: Signature Natural Fluid Scroll --}}
    @include('sections.hero')

    {{-- Who We Are Section --}}
    @include('sections.who-we-are')

    {{-- Services Signature Marquee Strip --}}
    @include('sections.services')

    {{-- Works Showcase Section --}}
    @include('sections.works')
    {{-- Why & Process Integrated Horizontal Transition Stage --}}
    <div class="why-process-track-wrapper" id="why-process-wrapper">
        <div class="why-process-track" id="why-process-track">
            @include('sections.why')
            @include('sections.engineered-bridge')
            @include('sections.process')
        </div>
    </div>
    @include('sections.faq')
    @include('sections.cta')

    {{-- Odds Studio Signature Footer --}}
    <x-footer :settings="$settings" />

    <x-odds-chat-widget />
</x-layout>
