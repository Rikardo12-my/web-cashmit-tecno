@extends('layout.admin.master')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-3xl font-semibold text-indigo-700 mb-6">
        Tambah User Baru
    </h1>

    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <label class="block mb-2 font-medium text-gray-700">Nama</label>
            <input name="nama" class="w-full p-3 border rounded-xl mb-4" placeholder="Nama">

            <label class="block mb-2 font-medium text-gray-700">NIM / NIP</label>
            <input name="nim_nip" class="w-full p-3 border rounded-xl mb-4" placeholder="NIM/NIP">

            <label class="block mb-2 font-medium text-gray-700">Email</label>
            <input name="email" type="email" class="w-full p-3 border rounded-xl mb-4" placeholder="Email">

            <label class="block mb-2 font-medium text-gray-700">Password</label>
            <input name="password" type="password" class="w-full p-3 border rounded-xl mb-4">

            <label class="block mb-2 font-medium text-gray-700">Role</label>
            <select name="role" class="w-full p-3 border rounded-xl mb-4">
                <option value="customer">Customer</option>
                <option value="petugas">Petugas</option>
                <option value="admin">Admin</option>
            </select>

            <button class="w-full bg-indigo-600 text-white py-3 rounded-xl hover:bg-indigo-700">
                Tambah User
            </button>

        </form>

    </div>

</div>
@endsection
