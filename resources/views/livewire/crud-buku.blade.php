<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="pb-10 px-12">
                    <button type="button" wire:click="ResetInput()" class="btn btn-success m-4" data-toggle="modal" data-target="#AddModal">Add New Buku</button>
                    <button type="button" wire:click="ListBuku()" class="btn btn-outline-secondary float-end m-4" >View As Siswa</button>
                    <div class="mb-3">
                      <input type="text" id="search" class="form-control" wire:model="searchterm" placeholder="Type to search buku..."/>
                    </div>
                    <table class="table table-fixed m-2">
                        <thead>
                            <th class="py-4 w-1/12">No</th>
                            <th class="p-4 w-2/12">Judul Buku</th>
                            <th class="p-4 w-2/12">Penulis</th>
                            <th class="p-4 w-2/12">Penerbit</th>
                            <th class="p-4  w-1/12">Tahun Terbit</th>
                            <th class="p-4 w-2/12">Stok</th>
                            <th class="p-4 w-2/12">Foto Buku</th>
                            <th class="p-4 w-2/12">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($buku as $data)
                            <tr wire:poll.visible>
                                <td class="px-4">{{ $loop->iteration + (($buku->currentPage() -1) * $buku->perPage()) }}</td>
                                <td>{{ $data->judul_buku }}</td>
                                <td>{{ $data->penulis }}</td>
                                <td>{{ $data->penerbit }}</td>
                                <td>{{ $data->tahun_terbit }}</td>
                                <td class="px-4">{{ $data->stok }}</td>
                                <td><img loading="lazy" src="{{ asset('storage/'. $data->foto_buku) }}" alt="" width="200px"></td>
                                <td class="px-4 py-2">
                                  <div class="vstack gap-2">
                                    <button type="button" wire:click="editId({{ $data->id_buku }})" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">Edit</button>
                                    <button type="button" wire:click="deleteId({{ $data->id_buku }})" class="btn btn-danger mt-1"  data-toggle="modal" data-target="#deleteModal">Delete</button>
                                  </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    <table>
                    {{ $buku->links() }}
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="judul_buku" class="col-form-label">Judul Buku</label>
                      <input type="text" class="form-control" id="judul_buku" name="judul_buku" wire:model="judul_buku" required>
                    </div>
                    <div class="mb-3">
                      <label for="penulis" class="col-form-label">Penulis</label>
                      <input type="text" class="form-control" id="penulis" name="penulis" wire:model="penulis" required>
                    </div>
                    <div class="mb-3">
                      <label for="penerbit" class="col-form-label">Penerbit</label>
                      <input type="text" class="form-control" id="penerbit" name="penerbit" wire:model="penerbit" required>
                    </div>
                    <div class="mb-3">
                      <label for="tahun_terbit" class="col-form-label">Tahun Terbit</label>
                      <input type="text" class="form-control" id="terbit" name="tahun_terbit" wire:model="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                      <label for="stok" class="col-form-label">Stok</label>
                      <input type="number" class="form-control" id="stok" name="stok" wire:model="stok" min="1" required>
                    </div>
                    <div class="mb-2">
                      <label for="foto_buku" class="col-form-label">Foto Buku</label>
                      <div class="input-group">
                        <input type="file" class="form-control" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="image/*" id="foto_buku" name="foto_buku" wire:model="foto_buku" aria-describedby="fotofile">
                        <button class="btn btn-outline-secondary" type="button" id="btn-clear">Clear</button>
                      </div>
                      <small id="fotofile" class="form-text text-muted muted">Supported file: jpg,jpeg,png,svg,gif,jfif</small>
                    </div>
                    <div wire:loading wire:target="foto_buku" class="d-flex align-items-center">
                      <strong wire:loading wire:target="foto_buku">Loading...</strong>
                      <div wire:loading wire:target="foto_buku" class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:loading.attr="disabled" wire:target="foto_buku" wire:click.prevent="insert()" class="btn btn-success close-modal" data-dismiss="modal"
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="judul_buku" class="col-form-label">Judul Buku</label>
                      <input type="text" class="form-control" id="judul_buku" name="judul_buku" wire:model="judul_buku" required>
                    </div>
                    <div class="mb-3">
                      <label for="penulis" class="col-form-label">Penulis</label>
                      <input type="text" class="form-control" id="penulis" name="penulis" wire:model="penulis" required>
                    </div>
                    <div class="mb-3">
                      <label for="penerbit" class="col-form-label">Penerbit</label>
                      <input type="text" class="form-control" id="penerbit" name="penerbit" wire:model="penerbit" required>
                    </div>
                    <div class="mb-3">
                      <label for="tahun_terbit" class="col-form-label">Tahun Terbit</label>
                      <input type="text" class="form-control" id="terbit" name="tahun_terbit" wire:model="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                      <label for="stok" class="col-form-label">Stok</label>
                      <input type="number" class="form-control" id="stok" name="stok" wire:model="stok" min="1" required>
                    </div>
                    <div class="mb-3">
                      <label for="foto_buku" class="col-form-label">Foto Buku</label>
                      <div class="input-group">
                        <input type="file" class="form-control" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="image/*" id="foto_buku" name="foto_buku" wire:model="foto_buku" aria-describedby="fotofile">
                        <button class="btn btn-outline-secondary" type="button" id="btn-clear">Clear</button>
                      </div>
                      <small id="fotofile" class="form-text text-muted muted">Supported file: jpg,jpeg,png,svg,gif,jfif</small>
                    </div> 
                    <div wire:loading wire:target="foto_buku" class="d-flex align-items-center">
                      <strong wire:loading wire:target="foto_buku">Loading...</strong>
                      <div wire:loading wire:target="foto_buku" class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:loading.attr="disabled" wire:target="foto_buku" wire:click.prevent="edit()" class="btn btn-primary close-modal" data-dismiss="modal"
                >{{ __('Submit') }}</button>
              </div>
            </div>
          </div>
    </div>

    <script>
      $(document).ready(function() {
        $('#btn-clear').on('click', function(e) {
          var $el = $('#foto_buku');
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();
        });
      });
    </script>
</div>
