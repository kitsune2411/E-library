<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengembalian Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="pb-10 px-12">
                    <button type="button" wire:click="ResetInput()" class="btn btn-success m-4" data-toggle="modal" data-target="#AddModal">Kembalikan Buku</button>
                    <div class="mb-3">
                      <input type="text" id="search" class="form-control" wire:model="searchterm" placeholder="Type to search pengembalian..."/>
                    </div>
                    <table class="table table-auto m-2">
                        <thead>
                            <th class="px-4 py-2 w-20">No</th>
                            <th>Nama Siswa</th>
                            <th>Judul Buku</th>
                            <th>Denda</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th class="px-4 py-2">Hapus</th>
                        </thead>
                        <tbody>
                            @foreach ($pengembalian as $data)
                            <tr wire:poll.visible>
                                <td class="px-4">{{ $loop->iteration + (($pengembalian->currentPage() -1) * $pengembalian->perPage()) }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->judul_buku }}</td>
                                <td>Rp. {{ $data->denda }}</td>
                                <td>{{ date('d-M-Y', strtotime($data->tanggal_dipinjam)) }}</td>
                                <td>{{ date('d-M-Y', strtotime($data->tanggal_dikembalikan)) }}</td>
                                <td class="px-4 py-2">
                                    <button type="button" wire:click="deleteId({{ $data->id }})" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pengembalian->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Pengembalian Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                    <div class="mb-3" id="input-peminjam">
                        <label for="peminjam" class="col-form-label">Peminjam</label>
                        <select class="form-select peminjam" id="peminjam" name="peminjam" wire:model="peminjam"     searchable="Search here.."required>
                            <option value=""></option>
                            @foreach ($siswa as $peminjam)
                            <option value="{{ $peminjam->id }}">{{ $peminjam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="input-buku">
                        <label for="buku" class="col-form-label">Buku yang dipinjam</label>
                        <select class="form-select buku" id="buku" name="buku" wire:model="buku" required>
                            <option value=""></option>
                            @foreach ($book as $buku)
                            <option value="{{ $buku->id_buku }}">{{ $buku->judul_buku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="col-form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" wire:model="tanggal_pinjam" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="tanggal_pengembalian" class="col-form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" wire:model="tanggal_pengembalian" required>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button wire:loading.attr="disabled" wire:click.prevent='kembalikan()' type="submit" class="btn btn-success close-modal" data-dismiss="modal"
                >{{ __('Submit') }}</button>
              </div>
            </div>
          </div>
    </div>

</div>
