@extends('layout.main')

@section('content')
{{--    @if (Auth::user()->role !== 0) {--}}
{{--        abort(403); // or redirect--}}
{{--        }--}}
{{--    @endif--}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Activity Logs</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">User</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">IP Address</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Geo Location</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Timestamp</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($logs as $index => $log)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                    <td class="sorting_1">{{ $log->user->name }}</td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>{{ $log->geo_location }}</td>
                                    <td>{{ $log->timestamp }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>


{{--    <div class="container">--}}
{{--        <h1>Activity Logs</h1>--}}
{{--        <table class="table table-striped">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>User</th>--}}
{{--                <th>IP Address</th>--}}
{{--                <th>Geo Location</th>--}}
{{--                <th>Timestamp</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach ($logs as $log)--}}
{{--                <tr>--}}
{{--                    <td>{{ $log->user->name }}</td>--}}
{{--                    <td>{{ $log->ip_address }}</td>--}}
{{--                    <td>{{ $log->geo_location }}</td>--}}
{{--                    <td>{{ $log->timestamp }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        {{ $logs->links() }}--}}
{{--    </div>--}}

@endsection
