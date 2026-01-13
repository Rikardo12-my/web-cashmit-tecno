@extends('layout.admin.master')

@section('title', 'Manajemen User')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen User</h1>
                    <p class="text-gray-600 mt-2">Kelola semua pengguna sistem termasuk admin, petugas, dan customer</p>
                </div>
                <div class="flex items-center gap-4">
                    <button id="showStatisticsBtn" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistik</span>
                    </button>
                    <button id="addUserBtn" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl hover:from-cyan-600 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 font-medium">
                        <i class="fas fa-plus"></i>
                        <span>Tambah User</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div id="statisticsSection" class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Cards will be loaded dynamically -->
        </div>

        <!-- Filter and Search Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari nama, email, atau NIM/NIP..." class="w-full pl-10 pr-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 bg-blue-50/50">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-400"></i>
                    </div>
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Role</label>
                    <select id="roleFilter" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 bg-blue-50/50">
                        <option value="">Semua Role</option>
                        <option value="customer">Customer</option>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select id="statusFilter" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 bg-blue-50/50">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button id="resetFilters" class="px-4 py-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">User</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Role</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Kontak</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Terdaftar</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody" class="divide-y divide-blue-50">
                        <!-- Users will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div id="paginationContainer" class="px-6 py-4 border-t border-blue-50">
                <!-- Pagination will be loaded dynamically -->
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden text-center py-12">
            <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-users text-blue-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada user ditemukan</h3>
            <p class="text-gray-500">Coba ubah pencarian atau filter Anda</p>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-blue-100 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah User Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <form id="userForm" class="p-6 space-y-6">
            @csrf
            <input type="hidden" id="userId" name="id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" required class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- NIM/NIP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM/NIP *</label>
                    <input type="text" name="nim_nip" id="nim_nip" required class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Password (hidden in edit mode) -->
                <div id="passwordField">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <p class="text-sm text-gray-500 mt-1">Minimal 6 karakter</p>
                </div>

                <!-- Password Confirmation -->
                <div id="passwordConfirmationField">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select name="role" id="role" required class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="customer">Customer</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                    <div class="border-2 border-dashed border-blue-200 rounded-2xl p-6 text-center hover:border-blue-300 transition-colors duration-300">
                        <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImage" class="mx-auto w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg">
                        </div>
                        <div id="uploadArea" class="cursor-pointer">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-camera text-blue-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-600">Klik untuk upload foto</p>
                            <p class="text-sm text-gray-500 mt-1">JPG, PNG maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"></textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-blue-100">
                <button type="button" onclick="closeModal()" class="px-6 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-colors duration-300 font-medium">
                    Batal
                </button>
                <button type="submit" id="submitBtn" class="px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl hover:from-cyan-600 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl font-medium">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View User Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-blue-100 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Detail User</h3>
            <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <div class="p-6">
            <div class="text-center mb-6">
                <img id="viewFoto" src="" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-white shadow-lg">
                <h4 id="viewNama" class="text-xl font-bold text-gray-800 mt-4"></h4>
                <div id="viewRole" class="inline-block px-3 py-1 rounded-full text-sm font-medium mt-2"></div>
                <div id="viewStatus" class="inline-block px-3 py-1 rounded-full text-sm font-medium ml-2"></div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p id="viewEmail" class="text-gray-800"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">NIM/NIP</label>
                    <p id="viewNimNip" class="text-gray-800"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Telepon</label>
                    <p id="viewTelepon" class="text-gray-800"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                    <p id="viewTanggalLahir" class="text-gray-800"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Alamat</label>
                    <p id="viewAlamat" class="text-gray-800"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Terdaftar</label>
                    <p id="viewCreatedAt" class="text-gray-800"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus User?</h3>
            <p class="text-gray-600 mb-6">User yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="px-6 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-colors duration-300 font-medium">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium">
                    Hapus User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-slash text-yellow-500 text-2xl" id="statusIcon"></i>
            </div>
            <h3 id="statusTitle" class="text-xl font-bold text-gray-800 mb-2"></h3>
            <p id="statusMessage" class="text-gray-600 mb-6"></p>
            <div class="flex justify-center gap-3">
                <button onclick="closeStatusModal()" class="px-6 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-colors duration-300 font-medium">
                    Batal
                </button>
                <button onclick="confirmStatusChange()" id="statusActionBtn" class="px-6 py-3 rounded-xl text-white font-medium transition-all duration-300">
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Modal -->
<div id="statisticsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-blue-100 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Statistik User</h3>
            <button onclick="closeStatisticsModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <div class="p-6">
            <div id="statisticsModalContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Statistics will be loaded here -->
            </div>
            
            <!-- Chart Container -->
            <div class="mt-8">
                <canvas id="userChart" class="w-full h-64"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let userChart;
let userToDelete = null;
let userToChangeStatus = null;
let statusAction = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    loadStatistics();
    setupEventListeners();
});

// Event Listeners
function setupEventListeners() {
    // Add User Button
    document.getElementById('addUserBtn').addEventListener('click', () => openModal('add'));
    
    // Search Input
    document.getElementById('searchInput').addEventListener('input', debounce(loadUsers, 500));
    
    // Filters
    document.getElementById('roleFilter').addEventListener('change', loadUsers);
    document.getElementById('statusFilter').addEventListener('change', loadUsers);
    
    // Reset Filters
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
    
    // Statistics Button
    document.getElementById('showStatisticsBtn').addEventListener('click', showStatisticsModal);
    
    // Image Upload
    document.getElementById('uploadArea').addEventListener('click', () => document.getElementById('foto').click());
    
    // Form Submission
    document.getElementById('userForm').addEventListener('submit', handleSubmit);
}

// Load Users
async function loadUsers(page = 1) {
    const search = document.getElementById('searchInput').value;
    const role = document.getElementById('roleFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    const params = new URLSearchParams({
        search,
        role,
        status,
        page
    });
    
    try {
        const response = await fetch(`/admin/users?${params}`);
        const html = await response.text();
        
        // Parse HTML and extract table body and pagination
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const tableBody = doc.querySelector('#usersTableBody')?.innerHTML || '';
        const pagination = doc.querySelector('#paginationContainer')?.innerHTML || '';
        
        document.getElementById('usersTableBody').innerHTML = tableBody;
        document.getElementById('paginationContainer').innerHTML = pagination;
        
        // Show/hide no results message
        const noResults = document.getElementById('noResults');
        if (tableBody.trim() === '') {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
        
        // Add event listeners to pagination links
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                loadUsers(page);
            });
        });
        
    } catch (error) {
        console.error('Error loading users:', error);
        showNotification('error', 'Gagal memuat data user');
    }
}

// Load Statistics
async function loadStatistics() {
    try {
        const response = await fetch('/admin/users/statistics');
        const data = await response.json();
        
        // Update statistics cards
        document.getElementById('statisticsSection').innerHTML = `
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total User</p>
                        <p class="text-3xl font-bold mt-2">${data.total_users}</p>
                    </div>
                    <i class="fas fa-users text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Customer</p>
                        <p class="text-3xl font-bold mt-2">${data.total_customers}</p>
                    </div>
                    <i class="fas fa-user-tag text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Petugas</p>
                        <p class="text-3xl font-bold mt-2">${data.total_petugas}</p>
                    </div>
                    <i class="fas fa-user-cog text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Admin</p>
                        <p class="text-3xl font-bold mt-2">${data.total_admins}</p>
                    </div>
                    <i class="fas fa-user-shield text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Aktif</p>
                        <p class="text-3xl font-bold mt-2">${data.active_users}</p>
                    </div>
                    <i class="fas fa-user-check text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Banned</p>
                        <p class="text-3xl font-bold mt-2">${data.banned_users}</p>
                    </div>
                    <i class="fas fa-user-slash text-3xl opacity-80"></i>
                </div>
            </div>
        `;
        
    } catch (error) {
        console.error('Error loading statistics:', error);
    }
}

// Open Modal
function openModal(action, userId = null) {
    const modal = document.getElementById('userModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('userForm');
    const passwordField = document.getElementById('passwordField');
    const passwordConfirmationField = document.getElementById('passwordConfirmationField');
    
    // Reset form
    form.reset();
    document.getElementById('userId').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('uploadArea').classList.remove('hidden');
    
    if (action === 'edit' && userId) {
        title.textContent = 'Edit User';
        document.getElementById('submitBtn').textContent = 'Update User';
        
        // Hide password fields for edit
        passwordField.style.display = 'none';
        passwordConfirmationField.style.display = 'none';
        
        // Load user data
        loadUserData(userId);
    } else {
        title.textContent = 'Tambah User Baru';
        document.getElementById('submitBtn').textContent = 'Simpan User';
        
        // Show password fields for add
        passwordField.style.display = 'block';
        passwordConfirmationField.style.display = 'block';
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close Modal
function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('userModal').classList.remove('flex');
}

// Load User Data for Edit
async function loadUserData(userId) {
    try {
        const response = await fetch(`/admin/users/${userId}`);
        const data = await response.json();
        
        if (data.success) {
            const user = data.user;
            
            document.getElementById('userId').value = user.id;
            document.getElementById('nama').value = user.nama;
            document.getElementById('email').value = user.email;
            document.getElementById('nim_nip').value = user.nim_nip;
            document.getElementById('role').value = user.role;
            document.getElementById('telepon').value = user.telepon || '';
            document.getElementById('tanggal_lahir').value = user.tanggal_lahir || '';
            document.getElementById('alamat').value = user.alamat || '';
            
            // Show photo if exists
            if (user.foto) {
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadArea').classList.add('hidden');
                document.getElementById('previewImage').src = `/storage/${user.foto}`;
            }
        }
    } catch (error) {
        console.error('Error loading user data:', error);
        showNotification('error', 'Gagal memuat data user');
    }
}

// Preview Image
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('previewImage').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle Form Submission
async function handleSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const userId = document.getElementById('userId').value;
    const isEdit = userId !== '';
    
    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Menyimpan...';
    submitBtn.disabled = true;
    
    try {
        const url = isEdit ? `/admin/users/${userId}` : '/admin/users';
        const method = isEdit ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', data.message);
            closeModal();
            loadUsers();
            loadStatistics();
        } else {
            showNotification('error', data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error saving user:', error);
        showNotification('error', 'Terjadi kesalahan saat menyimpan');
    } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }
}

// View User
async function viewUser(userId) {
    try {
        const response = await fetch(`/admin/users/${userId}`);
        const data = await response.json();
        
        if (data.success) {
            const user = data.user;
            const modal = document.getElementById('viewModal');
            
            // Set user data
            document.getElementById('viewNama').textContent = user.nama;
            document.getElementById('viewEmail').textContent = user.email;
            document.getElementById('viewNimNip').textContent = user.nim_nip;
            document.getElementById('viewTelepon').textContent = user.telepon || '-';
            document.getElementById('viewTanggalLahir').textContent = user.tanggal_lahir || '-';
            document.getElementById('viewAlamat').textContent = user.alamat || '-';
            document.getElementById('viewCreatedAt').textContent = new Date(user.created_at).toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Set photo
            const foto = document.getElementById('viewFoto');
            if (user.foto) {
                foto.src = `/storage/${user.foto}`;
                foto.onerror = function() {
                    this.src = 'https://via.placeholder.com/128?text=User';
                };
            } else {
                foto.src = 'https://via.placeholder.com/128?text=User';
            }
            
            // Set role badge
            const roleBadge = document.getElementById('viewRole');
            roleBadge.textContent = user.role.toUpperCase();
            roleBadge.className = 'inline-block px-3 py-1 rounded-full text-sm font-medium mt-2 ';
            if (user.role === 'admin') {
                roleBadge.classList.add('bg-amber-100', 'text-amber-800');
            } else if (user.role === 'petugas') {
                roleBadge.classList.add('bg-purple-100', 'text-purple-800');
            } else {
                roleBadge.classList.add('bg-green-100', 'text-green-800');
            }
            
            // Set status badge
            const statusBadge = document.getElementById('viewStatus');
            statusBadge.textContent = user.status.toUpperCase();
            statusBadge.className = 'inline-block px-3 py-1 rounded-full text-sm font-medium ml-2 ';
            if (user.status === 'active') {
                statusBadge.classList.add('bg-emerald-100', 'text-emerald-800');
            } else {
                statusBadge.classList.add('bg-red-100', 'text-red-800');
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    } catch (error) {
        console.error('Error loading user data:', error);
        showNotification('error', 'Gagal memuat data user');
    }
}

// Close View Modal
function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
    document.getElementById('viewModal').classList.remove('flex');
}

// Confirm Delete
function confirmDeleteUser(userId, userName) {
    userToDelete = userId;
    
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close Delete Modal
function closeDeleteModal() {
    userToDelete = null;
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Delete User
async function confirmDelete() {
    if (!userToDelete) return;
    
    try {
        const response = await fetch(`/admin/users/${userToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', data.message);
            closeDeleteModal();
            loadUsers();
            loadStatistics();
        } else {
            showNotification('error', data.message || 'Gagal menghapus user');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        showNotification('error', 'Terjadi kesalahan saat menghapus');
    }
}

// Change User Status
function changeUserStatus(userId, currentStatus) {
    userToChangeStatus = userId;
    statusAction = currentStatus === 'active' ? 'ban' : 'activate';
    
    const modal = document.getElementById('statusModal');
    const title = document.getElementById('statusTitle');
    const message = document.getElementById('statusMessage');
    const actionBtn = document.getElementById('statusActionBtn');
    const icon = document.getElementById('statusIcon');
    
    if (statusAction === 'ban') {
        title.textContent = 'Banned User?';
        message.textContent = 'User yang dibanned tidak dapat login ke sistem. Apakah Anda yakin?';
        actionBtn.textContent = 'Ya, Banned User';
        actionBtn.className = 'px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium';
        icon.className = 'fas fa-user-slash text-yellow-500 text-2xl';
    } else {
        title.textContent = 'Aktifkan User?';
        message.textContent = 'User akan dapat login kembali ke sistem. Apakah Anda yakin?';
        actionBtn.textContent = 'Ya, Aktifkan User';
        actionBtn.className = 'px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 font-medium';
        icon.className = 'fas fa-user-check text-yellow-500 text-2xl';
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close Status Modal
function closeStatusModal() {
    userToChangeStatus = null;
    statusAction = null;
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
}

// Confirm Status Change
async function confirmStatusChange() {
    if (!userToChangeStatus || !statusAction) return;
    
    try {
        const url = statusAction === 'ban' 
            ? `/admin/users/${userToChangeStatus}/ban`
            : `/admin/users/${userToChangeStatus}/activate`;
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', data.message);
            closeStatusModal();
            loadUsers();
            loadStatistics();
        } else {
            showNotification('error', data.message || 'Gagal mengubah status user');
        }
    } catch (error) {
        console.error('Error changing user status:', error);
        showNotification('error', 'Terjadi kesalahan saat mengubah status');
    }
}

// Show Statistics Modal
async function showStatisticsModal() {
    const modal = document.getElementById('statisticsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Load detailed statistics
    await loadDetailedStatistics();
}

// Close Statistics Modal
function closeStatisticsModal() {
    document.getElementById('statisticsModal').classList.add('hidden');
    document.getElementById('statisticsModal').classList.remove('flex');
}

// Load Detailed Statistics
async function loadDetailedStatistics() {
    try {
        const response = await fetch('/admin/users/statistics');
        const data = await response.json();
        
        // Update modal content
        document.getElementById('statisticsModalContent').innerHTML = `
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total User</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">${data.total_users}</p>
                    </div>
                    <i class="fas fa-users text-blue-400 text-2xl"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Customer</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">${data.total_customers}</p>
                    </div>
                    <i class="fas fa-user-tag text-green-400 text-2xl"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Petugas</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">${data.total_petugas}</p>
                    </div>
                    <i class="fas fa-user-cog text-purple-400 text-2xl"></i>
                </div>
            </div>
        `;
        
        // Create chart
        createUserChart(data);
        
    } catch (error) {
        console.error('Error loading detailed statistics:', error);
    }
}

// Create User Chart
function createUserChart(data) {
    const ctx = document.getElementById('userChart').getContext('2d');
    
    // Destroy existing chart
    if (userChart) {
        userChart.destroy();
    }
    
    userChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Customer', 'Petugas', 'Admin', 'Aktif', 'Banned'],
            datasets: [{
                data: [
                    data.total_customers,
                    data.total_petugas,
                    data.total_admins,
                    data.active_users,
                    data.banned_users
                ],
                backgroundColor: [
                    '#10b981',
                    '#8b5cf6',
                    '#f59e0b',
                    '#059669',
                    '#ef4444'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            family: 'Inter, sans-serif'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1f2937',
                    bodyColor: '#1f2937',
                    borderColor: '#d1d5db',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6
                }
            },
            cutout: '60%'
        }
    });
}

// Reset Filters
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    loadUsers();
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Show Notification
function showNotification(type, message) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification fixed top-4 right-4 px-6 py-4 rounded-xl shadow-lg text-white font-medium transform transition-all duration-300 translate-x-full opacity-0 z-50`;
    
    if (type === 'success') {
        notification.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600');
    } else {
        notification.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600');
    }
    
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
        notification.classList.add('translate-x-0', 'opacity-100');
    }, 10);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.remove('translate-x-0', 'opacity-100');
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
</script>

<style>
.notification {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.badge-admin {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.badge-petugas {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.badge-customer {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.badge-active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.badge-banned {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
}
</style>
@endpush

@endsection