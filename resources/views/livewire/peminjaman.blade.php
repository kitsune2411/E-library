<div>
    {{-- Stop trying to control. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Peminjaman Buku
                    </div>

                    <div class="mt-6 text-gray-500">
                        <form  wire:submit.prevent='pinjam()'>
                            <div class="mb-3" id="input-peminjam">
                                <label for="peminjam" class="col-form-label">Peminjam</label>
                                <select class="form-select peminjam" id="peminjam" name="peminjam" wire:model="peminjam"     searchable="Search here.."required>
                                    <option value="0"></option>
                                    @foreach ($siswa as $peminjam)
                                    <option value="{{ $peminjam->id }}">{{ $peminjam->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="input-buku">
                                <label for="buku" class="col-form-label">Buku yang dipinjam</label>
                                <select class="form-select buku" id="buku" name="buku" wire:model="buku" required>
                                    <option value="0"></option>
                                    @foreach ($book as $buku)
                                    <option value="{{ $buku->id_buku }}">{{ $buku->judul_buku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="col-form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" wire:model="tanggal_pinjam" required>
                            </div>

                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>

                        @foreach ($peminjaman as $data)
                           {{ $data->name }} pinjam {{ $data->judul_buku }} pada {{ $data->created_at }}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
