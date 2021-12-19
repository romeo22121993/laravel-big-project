@extends('frontend.main_master')
@section('content')

@section('title')
   Chat1
@endsection

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <h3>Chat Page</h3>
        </div>
    </div>
</div>

<div class="body-content outer-top-xs">
    <div id="app">
        <container></container>
    </div>
</div>
<br/>
<br/>
<br/>
<br/>
@endsection

<script src="{{ asset('js/app.js') }}"></script>


