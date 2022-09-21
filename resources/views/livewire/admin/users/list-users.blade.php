<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                        <button wire:click.prevent="addNew" class="btn btn-primary">Add New User</button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$loop -> iteration}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a href="" wire:click.prevent="edit({{$user}})">
                                                <i class="fa fa-edit mr-2"></i>
                                            </a>
                                            <a href="">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="createUser">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if($showEditModal)
                        <span>Edit User</span>
                        @else
                        <span>Add New User</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model.defer="state.name" class="form-control @error('name') is-invalid" @enderror id="name" aria-describedby="nameHelp" placeholder="Enter name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model.defer="state.password" class="form-control @error('password') is-invalid" @enderror id="password" placeholder="Password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="passwordConfirmation">Confirm Password</label>
                            <input type="password" wire:model.defer="state.password_confirmation" class="form-control @error('password_confirmation') is-invalid" @enderror id="passwordConfirmation" placeholder="Confirm Password">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
