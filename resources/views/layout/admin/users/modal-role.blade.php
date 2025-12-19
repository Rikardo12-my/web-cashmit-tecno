<div id="roleModal"
    class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-xl w-96 shadow-lg">
        <h2 class="text-lg font-semibold mb-3">Ubah Role Pengguna</h2>

        <form id="roleForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="user_id" id="roleUserId">

            <label class="block text-sm font-medium">Pilih Role Baru</label>
            <select name="role" id="roleSelect"
                class="w-full border rounded-lg mt-1 p-2">
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="customer">Customer</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                    onclick="closeRoleModal()"
                    class="px-3 py-1 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Tutup
                </button>

                <button type="submit"
                    class="px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRoleModal(userId) {
        // Set action form sesuai URL Controller kamu
        let url = "/admin/users/" + userId + "/update-role";

        document.getElementById('roleForm').action = url;
        document.getElementById('roleUserId').value = userId;

        document.getElementById('roleModal').classList.remove('hidden');
        document.getElementById('roleModal').classList.add('flex');
    }

    function closeRoleModal() {
        document.getElementById('roleModal').classList.remove('flex');
        document.getElementById('roleModal').classList.add('hidden');
    }
</script>
