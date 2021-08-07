<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @foreach ($cms as $data)
        
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $data->header }}
        </h2>
        <small>Halaman ini dapat diakses oleh semua user</small>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        {{ $data->title }}
                    </div>
                    
                    <div class="mt-6 text-gray-500">
                        <?= $data->content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
