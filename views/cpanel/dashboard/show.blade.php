@extends('cpanel.cpanel')
@section('page_title', 'Dashboard')
@section('page_content')

    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $recipients }}</h3>
                    <p>Recipients</p>
                </div>
                <div class="icon"><i class="ion ion-bag"></i></div>
                <a href="/recipients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $departments }}</h3>
                    <p>Departments</p>
                </div>
                <div class="icon"><i class="ion ion-stats-bars"></i></div>
                    <a href="/departments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $users }}</h3>
                    <p>Users</p>
                </div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                    <a href="/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
        </div>
        <!-- ./col -->
    </div>

@endsection