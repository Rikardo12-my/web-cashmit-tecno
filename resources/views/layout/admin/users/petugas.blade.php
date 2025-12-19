@extends('layout.admin.master')

@section('content')
<div class="p-6">

    <h1 class="text-3xl font-semibold text-indigo-700 mb-6">
        Daftar Petugas
    </h1>

    <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200 overflow-x-auto">

        <table class="w-full text-left min-w-[700px]">
            <thead class="text-gray-600 font-medium border-b">
                <tr>
                    <th class="py-3">Nama</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($petugas as $user)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3">{{ $user->nama ?? '-' }}</td>
                    <td>{{ $user->nim_nip ?? '-' }}</td>
                    <td>{{ $user->email ?? '-' }}</td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-sm
                            {{ ($user->status ?? '') == 'active'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($user->status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="space-x-2">

                        {{-- Suspend / Activate --}}
                        @if(($user->status ?? '') == 'active')
                            <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white rounded-xl hover:bg-red-600 text-sm">
                                    Suspend
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 bg-green-500 text-white rounded-xl hover:bg-green-600 text-sm">
                                    Activate
                                </button>
                            </form>
                        @endif

                        {{-- Ubah Role: gunakan data-* attribute untuk JS --}}
                        <button type="button"
                            data-id="{{ $user->id }}"
                            data-role="{{ $user->role ?? 'petugas' }}"
                            class="btn-open-role px-3 py-1 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 text-sm">
                            Ubah Role
                        </button>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">
                        Belum ada data petugas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@include('layout.admin.users.modal-role')

@endsection
<script>
    // Pasang event listener ke semua tombol dengan class 'btn-open-role'
    document.querySelectorAll('.btn-open-role').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            openRoleModal(userId);
        });
    });
</script>