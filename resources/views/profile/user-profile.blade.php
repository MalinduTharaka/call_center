@extends('layouts.app')
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="profile-bg-picture"
                style="background-image:url('logos/cover.png')">
                <span class="picture-bg-overlay"></span>
                <!-- overlay -->
            </div>
            <!-- meta -->
            <div class="profile-user-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-user-img"><img src="logos/wishwaads.jpg" alt=""
                                class="avatar-lg rounded-circle"></div>
                        <div class="">
                            <h4 class="mt-4 fs-17 ellipsis">User ID :{{ Auth::user()->id }}</h4>
                            <p class="font-13">User Name :{{ Auth::user()->name }}</p>
                            <p class="text-muted mb-0"> User Role :{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ meta -->
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#aboutme" type="button" role="tab"
                                    aria-controls="home" aria-selected="true" href="#aboutme">User Profile</a>
                            </li>
                            @if (Auth::user()->role == 'cro')
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#user-activities"
                                    type="button" role="tab" aria-controls="user-activities" aria-selected="true">
                                        Call Center Activity
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    @include('profile.sections.user-activity')
                                </div> <!-- end profile-desk -->
                            </div> <!-- about-me -->

                            <!-- Activities -->
                            <div id="user-activities" class="tab-pane">
                               @include('profile.sections.call-center-activity')
                            </div>

                            <!-- settings -->
                            <div id="edit-profile" class="tab-pane">
                                
                            </div>

                            <!-- profile -->
                            <div id="projects" class="tab-pane">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

</div>
<!-- end row -->

</div>
<!-- container -->

@endsection