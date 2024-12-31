@extends('layouts.frontapp')
@section('title', 'User Dashboard')

@section('content')

    <section class="account_section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-8">
                    <div class="account_content_area">
                        <h3>Make Your Role</h3>
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-sm-6">
                                <a href="{{ route('make.role.fundraiser') }}">
                                    <div class="count_box">
                                        <h4>Fundraiser</h4>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <a href="{{ route('make.role.donor') }}">
                                    <div class="count_box">
                                        <h4>Donor</h4>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
