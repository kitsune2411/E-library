<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="pb-10 px-12">
                    <button type="button" wire:click="ResetInput()" class="btn btn-success m-4" data-toggle="modal" data-target="#AddModal">Create siswa</button>
                    <table class="table table-auto m-2">
                        <thead>
                            <th class="px-4 py-2 w-20">No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>NIS</th>
                            <th>Email</th>
                            <th class="px-4 py-2">Action</th>
                        </thead>
                        <tbody>
                            <?php $no=1 ?>
                            @foreach ($user as $data)
                            <tr>
                                <td class="px-4">{{ $no++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->username }}</td>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->email }}</td>
                                <td class="px-4 py-2">
                                    <button type="button" wire:click="editId({{ $data->id }})" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">Edit</button>
                                    <button type="button" wire:click="deleteId({{ $data->id }})" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    <table>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal"
                        data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div wire:ignore.self class="modal fade" id="AddModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <x-jet-validation-errors class="mb-4" />
                <form>
                  @csrf
                  <div class="mb-3">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" wire:model="name" required>
                  </div>
                  <div class="mb-3">
                    <label for="username" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" wire:model="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="nis" class="col-form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" wire:model="nis" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" wire:model="email" required>
                  </div>
                  {{-- <div class="mb-3">
                    <label for="level" class="col-form-label">Level</label>
                    <select class="form-select" aria-label="Default select example" name="level" wire:model="level" required>
                        <option selected>select level</option>
                        <option value="1">Admin</option>
                        <option value="2">Petugas Perpustakaan</option>
                        <option value="3">Siswa</option>
                    </select>
                  </div> --}}
                  <div class="mb-3">
                    <label for="password" class="col-form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" wire:model="password" aria-describedby="passwordHelpBlock" required>
                    <div id="passwordHelpBlock" class="form-text">
                      Your password must be 8 or more characters long.
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:click.prevent="insert()" class="btn btn-success close-modal" data-dismiss="modal"
                >{{ __('Submit') }}</button>
              </div>
            </div>
          </div>
    </div>

    <!-- Edit Modal -->
    <div wire:ignore.self class="modal fade" id="EditModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <x-jet-validation-errors class="mb-4" />
                <form>
                  @csrf
                  <div class="mb-3">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" wire:model="name" required>
                  </div>
                  <div class="mb-3">
                    <label for="username" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" wire:model="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="nis" class="col-form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" wire:model="nis" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" wire:model="email" required>
                  </div>
                  {{-- <div class="mb-3">
                    <label for="level" class="col-form-label">Level</label>
                    <select class="form-select" aria-label="Default select example" name="level" wire:model="level" required>
                        <option selected>select level</option>
                        <option value="1">Admin</option>
                        <option value="2">Petugas Perpustakaan</option>
                        <option value="3">Siswa</option>
                    </select>
                  </div> --}}
                  {{-- <div class="mb-3">
                    <label for="password" class="col-form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" wire:model="password" required>
                  </div> --}}
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:click.prevent="edit()" class="btn btn-primary close-modal" data-dismiss="modal"
                >{{ __('Submit') }}</button>
              </div>
            </div>
          </div>
    </div>


</div>
