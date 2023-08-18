@extends('layouts.landing')
@section('content')
<?php



 ?>
<div class="container">
   <div class="row padding">
    <?= isset($content)?$content->contenttext:""; ?>
   </div>
</div>
        
@endsection('content')


                            
                           