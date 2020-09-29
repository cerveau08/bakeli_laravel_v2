@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Admin Dashboard</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Admin Dashboard
                         </div>
                         <div class="card-body">
                             Hello Admin
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection