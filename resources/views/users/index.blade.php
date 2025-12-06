<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
            <div>

                <h1 class="text-3xl font-bold text-foreground">Pengguna</h1>
            </div>
            <button @click="$dispatch('open-modal', 'user-modal')" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out flex items-center shadow-lg shadow-indigo-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pengguna
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
                                    <th class="px-6 py-3 font-medium">Email</th>
                                    <th class="px-6 py-3 font-medium">Role</th>
                                    <th class="px-6 py-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach($users as $user)
                                    <tr class="text-sm group hover:bg-background/50 transition-colors">
                                        <td class="px-6 py-4 text-foreground font-medium">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-muted">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="$dispatch('open-modal', 'user-modal'); $dispatch('edit-user', {{ $user }})" class="text-[#5D5FEF] hover:text-[#4b4ddb] mr-3">Edit</button>
                                            @if($user->id !== auth()->id())
                                                <button type="button" class="text-red-400 hover:text-red-300" onclick="confirmDelete('{{ $user->id }}')">Delete</button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="user-modal" :show="false" focusable>
        <form method="post" action="{{ route('users.store') }}" class="p-6" x-data="{ isEdit: false, user: {} }" @edit-user.window="isEdit = true; user = $event.detail; $el.action = '{{ route('users.index') }}/' + user.id; $el.querySelector('[name=_method]').value = 'PUT'" @open-modal.window="if($event.detail === 'user-modal' && !isEdit) { isEdit = false; user = {}; $el.action = '{{ route('users.store') }}'; $el.querySelector('[name=_method]').value = 'POST' }">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <h2 class="text-lg font-medium text-foreground" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna'"></h2>

            <div class="mt-6">
                <x-input-label for="name" value="Nama" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" x-model="user.name" required autofocus />
            </div>

            <div class="mt-6">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" x-model="user.email" required />
            </div>

            <div class="mt-6">
                <x-input-label for="role" value="Role" />
                <select id="role" name="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" x-model="user.role" required>
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" x-bind:required="!isEdit" />
                <p class="text-xs text-muted mt-1" x-show="isEdit">Leave blank to keep current password</p>
            </div>

            <div class="mt-6">
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" x-bind:required="!isEdit" />
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
