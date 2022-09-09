<footer class="footer text-center text-white">
    <div class="container p-2">
        @php $socials = ['facebook', 'twitter', 'github', 'linkedin', 'youtube', 'instagram'] @endphp
        @foreach($socials as $social)
            @if($settings->$social != null)
                <div class="text-center d-inline-block" data-toggle="tooltip" data-placement="top" title="{{ ucfirst($social )}} Adresimiz">
                    <a href="{{ $settings->$social }}" target="_blank" class="text-decoration-none">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-{{$social}} fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        @if($settings->footer_text)
            {{ $settings->footer_text }}
        @endif
        <span class="text-center d-block">© {{ \Carbon\Carbon::now()->format('Y') }} WikiGame</span>
    </div>
</footer>
