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
                    <div class="d-flex justify-content-between mb-2">
                        <button wire:click.prevent="addNew" class="btn btn-primary">Add New User</button>
                        <x-search-input wire:model="searchTerm"/>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        Name
                                        <span wire:click="sortBy('name')" class="float-right text-sm"
                                              style="cursor: pointer">
                                        <i class="fa fa-arrow-up {{$sortColumnName === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                        <i class="fa fa-arrow-down {{$sortColumnName === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                    </span>
                                    </th>
                                    <th scope="col">
                                        Email
                                        <span wire:click="sortBy('email')" class="float-right text-sm"
                                              style="cursor: pointer">
                                        <i class="fa fa-arrow-up {{$sortColumnName === 'email' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                        <i class="fa fa-arrow-down {{$sortColumnName === 'email' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                    </span>
                                    </th>
                                    <th scope="col">Register Date</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($users as $index => $user)
                                    <tr>
                                        <th scope="row">{{$users->firstItem() + $index}}</th>
                                        <td>
                                            <img src="{{$user->avatar_url}}" class="img img-circle mr-1"
                                                 style="width: 50px">
                                            {{$user->name}}
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            {{--Dấu ?, khi ngày trống thi nó trả về null và không gọi tới hàm toFormattedDate()--}}
                                            {{$user->created_at?->toFormattedDate() ?? 'N/A'}}
                                        </td>
                                        <td>
                                            <select name="" id="" class="form-control"
                                                    wire:change="changeRole({{$user}}, $event.target.value)">
                                                <option value="admin" {{$user->role === 'admin' ? 'selected' : ''}}>
                                                    ADMIN
                                                </option>
                                                <option value="user" {{$user->role === 'user' ? 'selected' : ''}}>USER
                                                </option>
                                            </select></td>
                                        <td>
                                            <a href="" wire:click.prevent="edit({{$user}})">
                                                <i class="fa fa-edit mr-2"></i>
                                            </a>
                                            <a href="" wire:click.prevent="confirmUserRemove({{$user->id}})">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">
                                            <img
                                                src="https://img.freepik.com/premium-vector/file-found-illustration-with-confused-people-holding-big-magnifier-search-no-result_258153-336.jpg?w=2000"
                                                alt="No result" width="300">
                                            No result found
                                        </td>

                                    </tr>
                                @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            {{ $users->links() }}
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
            <form wire:submit.prevent="{{$showEditModal ? 'updateUser' : 'createUser'}}">
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
                            <input type="text" wire:model.defer="state.name"
                                   class="form-control @error('name') is-invalid" @enderror id="name"
                                   aria-describedby="nameHelp" placeholder="Enter name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" wire:model.defer="state.email"
                                   class="form-control @error('email') is-invalid @enderror" id="email"
                                   aria-describedby="emailHelp" placeholder="Enter email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model.defer="state.password"
                                   class="form-control @error('password') is-invalid" @enderror id="password"
                                   placeholder="Password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="passwordConfirmation">Confirm Password</label>
                            <input type="password" wire:model.defer="state.password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid"
                                   @enderror id="passwordConfirmation" placeholder="Confirm Password">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirmation">Profile Photo</label>
                            <div class="custom-file">
                                <div x-data="{isUploading: false, progress: 5}"
                                     x-on:livewire-upload-start="isUploading = true"
                                     x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                     x-on:livewire-upload-error="isUploading = false"
                                     x-on:livewire-upload-progress="progress = $event.detail.progress"
                                >
                                    <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
                                    <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                             x-bind:style="`width:${progress}%`">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-file-label" for="customFile">
                                    @if($photo)
                                        {{$photo->getClientOriginalName()}}
                                    @else
                                        Choose Image
                                    @endif
                                </label>
                            </div>
                            @if($photo)
                                <img src="{{$photo->temporaryUrl()}}" class="img d-block mt-2 w-100">
                            @else
                                <img src="{{$state['avatar_url'] ?? ''}}" class="img d-block mb-2 w-100">
                            @endif
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            @if($showEditModal)
                                <span>Save Change</span>
                            @else
                                <span>Save</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Delete User</h3>
                </div>
                <div class="modal-body">
                    <h4>Are you want to delete User ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger">Delete User</button>
                </div>
            </div>
        </div>
    </div>
</div>
