@extends('layouts.main')
@section('content')
<div class="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hero-heading">
                <span class="header">Practise your pitches with yoodli</br></span> 
            </div>
            <div class="col-md-6 text-right">
                <a href="https://speak2impact.yoodli.ai" target="_blank">
                    <button class="custom_button"> Open in New Window</button> 
                </a>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="row">
        {{-- <div class="col-md-6 offset-md-3"> --}}
        <div class="col-md-12">
        <div class="calendly-inline-widget" data-url="https://speak2impact.yoodli.ai" style="min-height:850px; height:850px; overflow: auto" align="center">
            <iframe src="https://speak2impact.yoodli.ai" style="min-height:850px; width:100%"></iframe>
            
        </div>
        </div>
    </div>
       
</div>
@endsection('content')