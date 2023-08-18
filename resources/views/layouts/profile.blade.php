@extends('layouts.main')
@section('content')
<div class="container emp-profile ff">
            <form method="post">
            <div class="row mt-5 mh-100">
                    <div class="col-md-2">
                       
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="rounded-circle mx-auto d-block" alt="avatar">
                    <br/>
                    <div class="profile-work text-center">
                        <h5 class="cfhp">
                                        Bilal Bashir
                                    </h5>
                                    <h6 class="cfhpd">
                                        UI UX Designer
                                    </h6>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; Karachi</p>
                        </div> 
                    </div>
                    <div class="col-md-7 offset-md-2">
                        <div class="profile-head">
                                   
                            <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Contact Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">About</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content profile-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row mt-5">
                                                <div class="col-md-4">
                                                    <h6 class="cfh">Name</h6>
                                                    <p class="cf">Bilal Bashir</p>
                                                </div>
                                                <div class="col-md-4">
                                                <h6 class="cfh">Phone Number</h6>
                                                    <p class="cf">+92 310 206 9028</p>
                                                </div>
                                                <div class="col-md-4">
                                                <h6 class="cfh">Phone Number</h6>
                                                    <p class="cf">+92 310 206 9028</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <h6 class="cfh">Password</h6>
                                                    <p class="cf">*********</p>
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                            <div class="col-md-2">
                                            <button class="btn btn-custom"><i class="fa fa-pencil"></i>&nbsp; Edit Contact Info</button>
                                            </div>
                                            </div>
                                            
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row mt-5">
                                                <div class="col-md-10">
                                                    <h6 class="cfh">About</h6>
                                                    <p class="cf">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                                </div>
                                                
                                            </div>
                                            <div class="row mt-3">
                                            <div class="col-md-2">
                                            <button class="btn btn-custom"><i class="fa fa-pencil"></i>&nbsp; Edit Contact Info</button>
                                            </div>
                                            </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                    </div> -->
                </div>
            </form>           
        </div>
@endsection('content')

