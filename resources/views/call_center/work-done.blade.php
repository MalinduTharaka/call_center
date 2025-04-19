@extends('layouts.app')

@section('content')
<div class="container">

  <!-- Nav Pills -->
  <ul class="nav nav-pills nav-justified mb-4" id="workTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" 
              id="video-editors-tab" 
              data-bs-toggle="pill" 
              data-bs-target="#video-editors" 
              type="button" 
              role="tab" 
              aria-controls="video-editors" 
              aria-selected="true">
        <i class="mdi mdi-video"></i> Video Editors
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" 
              id="actors-tab" 
              data-bs-toggle="pill" 
              data-bs-target="#actors" 
              type="button" 
              role="tab" 
              aria-controls="actors" 
              aria-selected="false">
        <i class="mdi mdi-account"></i> Actors
      </button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="workTabsContent">
    <!-- Video Editors Pane -->
    <div class="tab-pane fade show active" 
         id="video-editors" 
         role="tabpanel" 
         aria-labelledby="video-editors-tab">
      @include('call_center.video-editors-work-done', [
        'entries' => $videoEntries,
        'users'   => $users
      ])
    </div>

    <!-- Actors Pane -->
    <div class="tab-pane fade" 
         id="actors" 
         role="tabpanel" 
         aria-labelledby="actors-tab">
      @include('call_center.actors-work-done', [
        'entries' => $actorEntries,
        'users'   => $users
      ])
    </div>
  </div>
</div>
@endsection