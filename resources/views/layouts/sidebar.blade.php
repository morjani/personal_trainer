<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="index-2.html" class="app-brand-link">
                     <span class="app-brand-logo demo">
                        <img src="{{ getSiteLogo() }}">
                     </span>
            <span class="app-brand-text demo menu-text fw-bold">Kaimove</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

        <li class="menu-item">
            <a href="{{ route('settings') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Configuration">Configuration</div>
            </a>
        </li>
    </ul>
</aside>
