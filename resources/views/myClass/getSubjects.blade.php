@extends('layout.main')
@section('content')


    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Subject in <b>{{ $class->name }}</b></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">My Subject</li>
                        </ol>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class=" content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @if($subjects->isEmpty())
                        <p>No subject found.</p>
                    @else
                        @foreach( $subjects as $item )
                            <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $item->name }}</h3>
                                    <p>{{ $item->teacher_name }}</p>
                                </div>
        {{--                        <div class="icon">--}}
        {{--                            <i class="ion ion-bag"></i>--}}
        {{--                        </div>--}}
                                <a href="{{ route('class.materials', ['subject_id' => $item->subject_id]) }}" class="small-box-footer bg-secondary" onclick="showOverlay()">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <a href="{{ route('myClass.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection
