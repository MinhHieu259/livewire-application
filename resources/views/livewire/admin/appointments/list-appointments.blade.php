<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            {{--            @if(session()->has('message'))--}}
            {{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
            {{--                <strong><i class="fa fa-check-circle mr-1"></i>{{session('message')}}</strong>--}}
            {{--                <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
            {{--                    <span aria-hidden="true">&times;</span>--}}
            {{--                </button>--}}
            {{--            </div>--}}
            {{--            @endif--}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{route('admin.appointments.create')}}">
                            <button class="btn btn-primary">Add New Appointments</button>
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$appointment->client->name}}</td>
                                        <td>{{$appointment->date}}</td>
                                        <td>{{$appointment->time}}</td>  {{--ham trong AppServiceProvider--}}
                                        <td> <span class="badge badge-{{$appointment->status_badge}}">{{$appointment->status}}</span></td>
                                        <td>
                                            <a href="{{route('admin.appointments.edit', $appointment)}}">
                                                <i class="fa fa-edit mr-2"></i>
                                            </a>
                                            <a href="" wire:click.prevent="confirmAppointmentRemoval({{$appointment->id}})">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">

                        </div>
                    </div>


                </div>
                <!-- /.col-md-6 -->

                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <x-confirmation-alert/>
</div>
