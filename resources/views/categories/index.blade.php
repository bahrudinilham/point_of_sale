<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
            <div>

                <h1 class="text-3xl font-bold text-foreground">Kategori</h1>
            </div>
            <button @click="$dispatch('open-modal', 'category-modal')" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out flex items-center shadow-lg shadow-indigo-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kategori
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

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border">
                                    <th class="px-6 py-3 font-medium">Name</th>
                                    <th class="px-6 py-3 font-medium">Slug</th>
                                    <th class="px-6 py-3 font-medium">Description</th>
                                    <th class="px-6 py-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach($categories as $category)
                                    <tr class="text-sm group hover:bg-background/50 transition-colors">
                                        <td class="px-6 py-4 text-foreground font-medium">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-muted">{{ $category->slug }}</td>
                                        <td class="px-6 py-4 text-muted">{{ $category->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="$dispatch('open-modal', 'category-modal'); $dispatch('edit-category', {{ $category }})" class="text-[#5D5FEF] hover:text-[#4b4ddb] mr-3">Edit</button>
                                            <button type="button" class="text-red-400 hover:text-red-300" onclick="confirmDelete('{{ $category->id }}')">Delete</button>
                                            <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
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
                        {{ $categories->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="category-modal" :show="false" focusable>
        <form method="post" action="{{ route('categories.store') }}" class="p-6" x-data="{ isEdit: false, category: {} }" @edit-category.window="isEdit = true; category = $event.detail; $el.action = '{{ route('categories.index') }}/' + category.id; $el.querySelector('[name=_method]').value = 'PUT'" @open-modal.window="if($event.detail === 'category-modal' && !isEdit) { isEdit = false; category = {}; $el.action = '{{ route('categories.store') }}'; $el.querySelector('[name=_method]').value = 'POST' }">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <h2 class="text-lg font-medium text-foreground" x-text="isEdit ? 'Edit Kategori' : 'Tambah Kategori'"></h2>

            <div class="mt-6">
                <x-input-label for="name" value="Nama Kategori" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" x-model="category.name" required autofocus />
            </div>

            <div class="mt-6">
                <x-input-label for="description" value="Deskripsi" />
                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" x-model="category.description"></textarea>
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
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Data kategori yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: isDark ? '#1f2937' : '#ffffff',
                color: isDark ? '#ffffff' : '#374151',
                customClass: {
                    popup: 'rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
