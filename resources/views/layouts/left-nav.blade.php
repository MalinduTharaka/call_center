<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('logos/wishwaads.jpg')}}" alt="logo" style="height: 60px; width: auto;">

        </span>
        <span class="logo-sm">
            <img src="{{ asset('logos/wishwaads.jpg')}}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('logos/wishwaads.jpg')}}" alt="logo" style="height: 60px; width: auto;">

        </span>
        <span class="logo-sm">
            <img src="{{ asset('logos/wishwaads.jpg')}}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Main</li>

            @if (Auth::user()->role == 'admin')
                <li class="side-nav-item">
                    <a href="/dashboard" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/new/orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> New Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/other_orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Other Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/packages" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Packages </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/actors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Actors </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/cro-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> CRO Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/video-editors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Video Editors </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/designers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/designer-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/design‑payments" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Design Payments </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/targets" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Target page </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/work-types" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Setings </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/update-center" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Update Center </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/advertisers/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Advertise </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/employees/centers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Call Centers/Add Centers </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/users/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> User Manage </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/invoices/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Invoices </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/quotation/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Quotation </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'cro')
                <li class="side-nav-item">
                    <a href="/dashboard" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/new/orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> New Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/other_orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Other Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/packages" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Packages </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/work-types" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Setings </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/invoices/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Invoices </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/quotation/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Quotation </span>
                    </a>
                </li>

            @elseif (Auth::user()->role == 'uca')
                <li class="side-nav-item">
                    <a href="/update-center" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Update Center </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/designer-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/video-editors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Video Editors </span>
                    </a>
                </li>

            @elseif (Auth::user()->role == 'adv')
                <li class="side-nav-item">
                    <a href="/advertisers/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Advertise </span>
                    </a>
                </li>

            @elseif (Auth::user()->role == 'dsg')
                <li class="side-nav-item">
                    <a href="/designers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'vde')
                <li class="side-nav-item">
                    <a href="/video-editors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Video Editors </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'acc')
                <li class="side-nav-item">
                    <a href="/dashboard" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/new/orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> New Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/other_orders" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Other Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/packages" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Packages </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/actors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Actors </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/cro-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> CRO Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/video-editors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Video Editors </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/designers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/designer-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/design‑payments" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Design Payments </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/targets" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Target page </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/work-types" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Setings </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/update-center" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Update Center </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/advertisers/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Advertise </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/employees/centers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Call Centers/Add Centers </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/users/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> User Manage </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/invoices/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Invoices </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="/quotation/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Quotation </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'act')
                <li class="side-nav-item">
                    <a href="/actors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Actors </span>
                    </a>
                </li>
            @endif


        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>