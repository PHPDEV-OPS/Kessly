@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
$companyProfile = \App\Models\Setting::get('company.profile', []);
$companyName = $companyProfile['name'] ?? 'Kessly Wine Distribution';
$companyWebsite = $companyProfile['website'] ?? null;
$companyEmail = $companyProfile['email'] ?? null;
$companyPhone = $companyProfile['phone'] ?? null;
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 py-md-4 flex-column flex-md-row gap-2">
            <div class="text-body text-center text-md-start mb-2 mb-md-0">
                &#169; {{ date('Y') }}
                @if($companyWebsite)
                    <a href="{{ $companyWebsite }}" target="_blank" class="footer-link fw-medium">{{ $companyName }}</a>
                @else
                    <span class="fw-medium">{{ $companyName }}</span>
                @endif
                <span class="d-none d-sm-inline-block">- All rights reserved</span>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-2 gap-md-3">
                @if($companyPhone)
                    <a href="tel:{{ $companyPhone }}" class="footer-link text-body small">
                        <i class='bx bx-phone me-1'></i>
                        <span class="d-none d-lg-inline">{{ $companyPhone }}</span>
                    </a>
                @endif
                @if($companyEmail)
                    <a href="mailto:{{ $companyEmail }}" class="footer-link text-body small">
                        <i class='bx bx-envelope me-1'></i>
                        <span class="d-none d-lg-inline">{{ $companyEmail }}</span>
                    </a>
                @endif
                <a href="{{ route('settings') }}" class="footer-link text-body small">
                    <i class='bx bx-cog me-1'></i>
                    <span class="d-none d-lg-inline">Settings</span>
                </a>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
