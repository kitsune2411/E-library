<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Content Management System') }}
        </h2>
        <small>Halaman ini dapat diakses oleh admin atau petugas perpustakaan</small>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Success:">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <div>
                    {{ session('message') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Halaman CMS (Content Management System)
                    </div>
                    <small>halaman ini berfungsi untuk mengubah isi halaman buku</small>
                
                    <div class="mt-6 text-gray-500">
                        <form>
                            @csrf
                            <div class="mb-3">
                              <label for="header" class="col-form-label">Header</label>
                              <input type="text" class="form-control" id="header" name="header" wire:model="header" required>
                            </div>
                            <div class="mb-3">
                              <label for="title" class="col-form-label">Title</label>
                              <input type="text" class="form-control" id="title" name="title" wire:model="title" required>
                            </div>
                            <div class="">
                              <label for="content" class="col-form-label">Content</label>
                              <textarea class="form-control" id="content" name="content" wire:model="content" rows="6" required>
                                 
                              </textarea>
                            </div>
                        </form>
                       
                        <button class="mt-5 mb-4 mx-2 btn btn-dark float-end mx-2" wire:click.prevent="update()">{{ __('Save') }}</button>
                        <button class="mx-2 mt-5 mb-4 btn border-dark float-end" wire:click.prevent="ResetInput()">{{ __('Reset') }}</button>
                           

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
