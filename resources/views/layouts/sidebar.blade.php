<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-detail"></i>
                        <span key="t-services">Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('services') }}" key="t-default">Services</a></li>
                        <li><a href="{{ route('categories') }}" key="t-saas">Catégories</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="bx bxs-user-detail">Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('customers') }}" key="t-customers">Clients</a>
                        </li>
                        <li>
                            <a href="{{ route('prospect') }}" key="t-prospect">Prospect</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="bx bx-receipt">Facturation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" data-action="redirect_bill"
                               data-hash="bills" key="t-default">Factures</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" data-action="redirect_bill"
                               data-hash="proforma" key="t-saas">Proforma</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="bx bx-calendar">Agenda</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" data-action="redirect_agenda"
                               data-hash=".fc-timeGridDay-button" key="t-default">Jour</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" data-action="redirect_agenda"
                               data-hash=".fc-timeGridWeek-button" key="t-default">Semaine</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" data-action="redirect_agenda"
                               data-hash=".fc-dayGridMonth-button" key="t-saas">Mois</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('users') }}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span key="fas fa-users">Utilisateurs</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="page-content">

