@extends('layouts.main')
@section('content')

<!-- ===============   Practice Start   ============== -->
<div class="daily-goals">
    <div class="container-main">
        <div class="daily-goal">
            <div class="trophy">
                <img src="./images/trophy.png" alt="">
            </div>
            <div class="daily-progress">
                {{-- <h3>Course Goals<span><img src="./images/edit.svg" alt="">Edit Goals</span></h3> --}}
                <h3>Course Goals</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small>Coming Soon</small>
            </div>
        </div>
    </div>
</div>
<!-- ===============   Practice End   ============== -->
<!-- ===============   Chapter Start   ============== -->
<div class="chapter-detail">
    <div class="container-main">
        <div class="chapter-detail-content">
            <div class="chapter-header">
                <h6>Chapter I</h6>
                <h1>Introduction to the public speaking</h1>
                <h6>Susie Ashfield, Instructor</h6>
            </div>
            <div class="chapter-playlist">
                <div class="chapter-video">
                    <iframe width="634" height="396" src="https://www.youtube.com/embed/b2AsjTUhAkg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="chapter-list">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Chapter I: Introduction to the public s...
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="play-list video-done">
                                        <img src="./images/Play button.svg" alt="">
                                        <span>The art of public speaking<small>2:01 mins</small></span>
                                    </div>
                                    <div class="play-list video-pause">
                                        <img src="./images/pause.svg" alt="">
                                        <span>The right way to express yourself<small>2:01 mins</small></span>
                                    </div>
                                    <div class="play-list video-play">
                                        <img src="./images/Play button.svg" alt="">
                                        <span>Tackle the fear of public speaking<small>2:01 mins</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Chapter II: Fear of Speaking
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="play-list video-done">
                                        <img src="./images/Play button.svg" alt="">
                                        <span>The art of public speaking<small>2:01 mins</small></span>
                                    </div>
                                    <div class="play-list video-pause">
                                        <img src="./images/pause.svg" alt="">
                                        <span>The right way to express yourself<small>2:01 mins</small></span>
                                    </div>
                                    <div class="play-list video-play">
                                        <img src="./images/Play button.svg" alt="">
                                        <span>Tackle the fear of public speaking<small>2:01 mins</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ===============   Chapter End   ============== -->
<div class="chapter-tabs">
    <div class="container-main">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Description</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Notes</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <p><strong>This is 963 placeholder content the Profile tab's associated content.</strong>
                    Clicking another tab will toggle the visibility of this one for the next.
                    The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                    tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
            </div>
        </div>
    </div>
</div>

<!-- ================   Modal   =============== -->
<!--<div class="action">
    <div class="container-main">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Get full access
        </button>
    </div>
</div>-->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="membership-plan-pop">
                    <div class="toggle-membership">
                        Monthly
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        </div>
                        Annually
                    </div>
                    <h3>$3588.00</h3>
                    <h6>Annual membership<span>$299.00/month</span></h6>
                    <button class="start-membership">Start membership</button>
                    <a href="#">Sign up for free</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
