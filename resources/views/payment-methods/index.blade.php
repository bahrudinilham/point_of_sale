<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex justify-between items-center">
            <div>

                <h1 class="text-3xl font-bold text-foreground">Metode Pembayaran</h1>
            </div>
            <button @click="$dispatch('open-modal', 'payment-method-modal')" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out flex items-center shadow-lg shadow-indigo-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Metode
            </button>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border">
                <div class="p-6">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border">
                                    <th class="px-6 py-3 font-medium">Name</th>
                                    <th class="px-6 py-3 font-medium">Slug</th>
                                    <th class="px-6 py-3 font-medium">Status</th>
                                    <th class="px-6 py-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach($paymentMethods as $method)
                                    <tr class="text-sm group hover:bg-background/50 transition-colors">
                                        <td class="px-6 py-4 text-foreground font-medium">{{ $method->name }}</td>
                                        <td class="px-6 py-4 text-muted">{{ $method->slug }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <span class="px-2 py-1 rounded text-xs font-semibold capitalize
                                                @if($method->color == 'blue') bg-blue-100 text-blue-700 border border-blue-200 dark:bg-[#172554] dark:text-[#60A5FA] dark:border-[#1e3a8a]
                                                @endif
                                            ">
                                                {{ $method->color }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="$dispatch('open-modal', 'payment-method-modal'); $dispatch('edit-payment-method', {{ $method }})" class="text-[#5D5FEF] hover:text-[#4b4ddb] mr-3">Edit</button>
                                            <button type="button" class="text-red-400 hover:text-red-300" onclick="confirmDelete('{{ $method->id }}')">Delete</button>
                                            <form id="delete-form-{{ $method->id }}" action="{{ route('payment-methods.destroy', $method) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $paymentMethods->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="payment-method-modal" :show="false" focusable>
        <form method="post" action="{{ route('payment-methods.store') }}" class="p-6" x-data="{ isEdit: false, method: { is_active: 1 } }" @edit-payment-method.window="isEdit = true; method = $event.detail; $el.action = '{{ route('payment-methods.index') }}/' + method.id; $el.querySelector('[name=_method]').value = 'PUT'" @open-modal.window="if($event.detail === 'payment-method-modal' && !isEdit) { isEdit = false; method = { is_active: 1 }; $el.action = '{{ route('payment-methods.store') }}'; $el.querySelector('[name=_method]').value = 'POST' }">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <h2 class="text-lg font-medium text-foreground" x-text="isEdit ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran'"></h2>

            <div class="mt-6">
                <x-input-label for="name" value="Nama Metode" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" x-model="method.name" required autofocus />
            </div>

            <div class="mt-6">
                <label for="is_active" class="inline-flex items-center">
                    <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_active" value="1" x-model="method.is_active" :checked="method.is_active == 1">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                </label>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    Simpan
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
