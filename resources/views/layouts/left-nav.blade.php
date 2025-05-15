<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('logos/wishwaads.jpg') }}" alt="logo" style="height: 60px; width: auto;">

        </span>
        <span class="logo-sm">
            <img src="{{ asset('logos/wishwaads.jpg') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('logos/wishwaads.jpg') }}" alt="logo" style="height: 60px; width: auto;">

        </span>
        <span class="logo-sm">
            <img src="{{ asset('logos/wishwaads.jpg') }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            @if (Auth::user()->role == 'admin')
                <li class="side-nav-item">
                    <a href="/dashboard" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarOrders" aria-expanded="false" aria-controls="sidebarOrders"
                        class="side-nav-link">
                        <i class="ri-survey-line"></i>
                        <span> Orders </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarOrders">
                        <ul class="side-nav-second-level">
                            <li class="side-nav-item">
                                <a href="/new/orders" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> New Orders </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/other_orders" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Other Orders </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/pdf-maker" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Images to PDF </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/invoices/manage" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Invoices </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/quotation/manage" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Quotations </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/incomes" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Income </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarProfiles" aria-expanded="false"
                        aria-controls="sidebarProfiles" class="side-nav-link">
                        <i class="ri-table-line"></i>
                        <span> Profiles </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarProfiles">
                        <ul class="side-nav-second-level">
                            <li class="side-nav-item">
                                <a href="/admin/orders" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Admin Orders All Access </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/admin/orders/or" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Admin Other Orders All Access </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/update/sheet" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> UpdateSheet </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/designers" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Designer </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/advertisers_all_order/manage" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Advertiser </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/update-center" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Update Center </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarWorks" aria-expanded="false" aria-controls="sidebarWorks"
                        class="side-nav-link">
                        <i class="ri-briefcase-line"></i>
                        <span> User Work </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarWorks">
                        <ul class="side-nav-second-level">
                            <li class="side-nav-item">
                                <a href="/actors-work" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Actors Work </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/cro-work" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> CRO Work </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/video-editors-work" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Video Editors Work </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/designer-work" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Designers Work </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarSetting" aria-expanded="false" aria-controls="sidebarSetting"
                        class="side-nav-link">
                        <i class="ri-pencil-ruler-2-line"></i>
                        <span> Refund </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSetting">
                        <ul class="side-nav-second-level">
                            <li class="side-nav-item">
                                <a href="/refund/orders/view" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Refunded Orders </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/refund/orders/OR/view" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Refunded other Orders </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarSetting" aria-expanded="false" aria-controls="sidebarSetting"
                        class="side-nav-link">
                        <i class="ri-pencil-ruler-2-line"></i>
                        <span> Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSetting">
                        <ul class="side-nav-second-level">
                            <li class="side-nav-item">
                                <a href="/users/manage" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Users </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/employees/centers" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Call Centers </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/packages" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span>Boosting Packages </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/design‑payments" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Design Payments </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/targets" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Targets </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/work-types" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span> Work Types </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/video-packages" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span>Video packages </span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="/time-slots" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span>Video Time Slots </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="/salary-rates" class="side-nav-link">
                                    {{-- <i class="ri-dashboard-3-line"></i> --}}
                                    <span>Salary Rates</span>
                                </a>
                            </li>

                        </ul>
                    </div>
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
                    <a href="/update/sheet" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> UpdateSheet </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/pdf-maker" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Images to PDF </span>
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
                <li class="side-nav-item">
                    <a href="/actors-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Actors Work </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'adv')
                <li class="side-nav-item">
                    <a href="/advertisers_all_order/manage" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Advertiser </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/advertisers/design/view" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designs </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/update/sheet" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> UpdateSheet </span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'dsg')
                <li class="side-nav-item">
                    <a href="/designers" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designer </span>
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
                    <a href="/accountant" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span>Orders </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/accountant/or" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Other Orders </span>
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
                    <a href="/designer-work" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Designers Work </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/design‑payments" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Manage Design Payments </span>
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