<div id="addMethodModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl">

        <h2 class="text-xl font-semibold text-indigo-600 mb-4">
            Tambah Metode Pembayaran
        </h2>

        <form action="{{ route('payment.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="text-sm text-gray-600">Nama</label>
                <input type="text" name="nama" class="w-full mt-1 p-2 border rounded-xl" required>
            </div>

            <div class="mb-3">
                <label class="text-sm text-gray-600">Kategori</label>
                <select name="kategori" class="w-full mt-1 p-2 border rounded-xl" required>
                    <option value="bank_qris">Bank / QRIS</option>
                    <option value="qris_cod">QRIS COD</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">Deskripsi</label>
                <textarea name="deskripsi" class="w-full mt-1 p-2 border rounded-xl"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal('addMethodModal')"
                    class="px-4 py-2 bg-gray-200 rounded-xl">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
