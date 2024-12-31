@extends('layouts.frontapp')
@section('title', 'User Dashboard')

@section('content')
    <!-- breadcrumb  -->
    <x-breadcrumb>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </x-breadcrumb>
    <!-- breadcrumb end  -->

    <section class="account_section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-8">
                    <div class="account_content_area">
                        <h3>My Dashboard</h3>
                        

                        <div class="alert alert-warning">
                            <p>Your account has been locked!</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
