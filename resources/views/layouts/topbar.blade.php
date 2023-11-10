<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('bills') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ getLogoSite() }}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ getLogoSite() }}" alt="" height="80" style="margin-top: 16px">
                                </span>
                </a>

                <a href="{{ route('bills') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ getLogoSite() }}" alt="" height="60">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ getLogoSite() }}" alt="" height="60">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>


        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    @if(count($notifs) > 0)

                        <span class="badge bg-danger rounded-pill">{{ count($notifs) }}</span>

                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('agenda') }}" class="small" key="t-view-all"> Voir tous</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">

                        @if(count($notifs) > 0)

                            @foreach($notifs as $notif)

                                <a href="javascript: void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                                            <i class="bx bx-badge-check"></i>
                                                        </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" key="t-shipped">{{  mb_strimwidth($notif->title, 0, 31, '...')  }}</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-grammer">{{ mb_strimwidth($notif->description, 0, 41, '...')  }}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">{{ date('Y-m-d',strtotime( $notif->date_start))  }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            @endforeach

                        @else

                            <div class="flex-grow-1">
                                <div class="font-size-12 text-muted text-center">
                                    <p class="mb-1" key="t-grammer">Aucune évènement</p>
                                </div>
                            </div>

                       @endif
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('agenda') }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">Voir tous</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ currentUser()->image }}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ currentUser()->user?->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#" data-action="show_profile" data-id="{{ currentUser()->user?->id }}">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <a class="dropdown-item" href="#" data-action="change_password" data-id="{{ currentUser()->user?->id }}">
                        <i class="bx bxs-lock font-size-16 align-middle me-1"></i> <span key="t-profile">Modifier le mot de passe</span></a>
                    <a class="dropdown-item d-block" href="{{ route('settings') }}">
                        <i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Configuration</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Déconnecter</span></a>
                </div>
            </div>

        </div>
    </div>
</header>
