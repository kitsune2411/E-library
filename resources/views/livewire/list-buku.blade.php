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
                    <h2 class="mt-4 mb-3">List Buku</h2>
                    <div class="mb-3">
                        <input type="text" id="search" class="form-control" wire:model="searchterm" placeholder="Type to search buku..."/>
                    </div>
                    @foreach ($buku as $data)
                    <div class="card m-3" wire:poll.visible>
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img loading="lazy" src="{{ asset('storage/'. $data->foto_buku) }}" class="img-fluid rounded-start"
                                    alt="..." width="250px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->judul_buku }}</h5>
                                    <dl class="row">
                                        <dt class="col-sm-3">Penulis</dt>
                                        <dd class="col-sm-9">{{ $data->penulis }}</dd>
                                        <dt class="col-sm-3">Penerbit</dt>
                                        <dd class="col-sm-9">{{ $data->penerbit }}</dd>
                                        <dt class="col-sm-3">Tahun Terbit</dt>
                                        <dd class="col-sm-9">{{ $data->tahun_terbit }}</dd>
    
                                    </dl>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
    
                </div>
            </div>
        </div>
    </div>

</div>
