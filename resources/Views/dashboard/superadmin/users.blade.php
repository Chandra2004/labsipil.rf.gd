@extends('dashboard.layouts.layout')
@section('dashboard-content')
<main class="p-4 sm:p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold font-headline text-primary">Manajemen Pengguna</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola data pengguna sistem, termasuk menambahkan, mengedit, dan menghapus pengguna.</p>
        </div>
        <button data-modal-target="addModal" data-modal-toggle="addModal" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-accent">
            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
            Tambah Pengguna
        </button>
    </div>
    <!-- Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="flex flex-col sm:flex-row items-center justify-between p-4">
            <h2 class="text-lg font-medium">Daftar Pengguna</h2>
            <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                <label for="role-filter" class="text-sm">Filter Role:</label>
                <div class="relative">
                    <select id="role-filter" class="w-44 p-2 border border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        <option value="praktikan">Praktikan</option>
                        <option value="asisten">Asisten</option>
                        <option value="pembimbing">Pembimbing</option>
                        <option value="superadmin">SuperAdmin</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="p-4">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Nama</th>
                        <th class="text-left py-2 hidden sm:table-cell">Email</th>
                        <th class="text-left py-2">NPM</th>
                        <th class="text-left py-2">Role</th>
                        <th class="text-right py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- Data statis untuk simulasi -->
                    <tr class="border-b">
                        <td class="py-2 font-medium">John Doe</td>
                        <td class="py-2 hidden sm:table-cell">john.doe@example.com</td>
                        <td class="py-2">1234567890</td>
                        <td class="py-2"><span class="badge-praktikan inline-block px-2 py-1 text-xs font-medium rounded">praktikan</span></td>
                        <td class="py-2 text-right">
                            <div class="relative">
                                <button class="p-2 hover:bg-gray-100 rounded-full" data-dropdown-toggle="dropdown-1">
                                    <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                                </button>
                                <div id="dropdown-1" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 absolute right-0 mt-2">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li><a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary" data-modal-target="editModal" data-modal-toggle="editModal">Edit</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary" data-modal-target="resetPasswordModal" data-modal-toggle="resetPasswordModal">Reset Password</a></li>
                                        <li><a href="#" class="block px-4 py-2 text-destructive hover:bg-accent" data-modal-target="deleteModal" data-modal-toggle="deleteModal">Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 font-medium">Jane Smith</td>
                        <td class="py-2 hidden sm:table-cell">jane.smith@example.com</td>
                        <td class="py-2">0987654321</td>
                        <td class="py-2"><span class="badge-asisten inline-block px-2 py-1 text-xs font-medium rounded">asisten</span></td>
                        <td class="py-2 text-right">
                            <div class="relative">
                                <button class="p-2 hover:bg-gray-100 rounded-full" data-dropdown-toggle="dropdown-2">
                                    <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                                </button>
                                <div id="dropdown-2" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 absolute right-0 mt-2">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li><a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary" data-modal-target="editModal" data-modal-toggle="editModal">Edit</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary" data-modal-target="resetPasswordModal" data-modal-toggle="resetPasswordModal">Reset Password</a></li>
                                        <li><a href="#" class="block px-4 py-2 text-destructive hover:bg-accent" data-modal-target="deleteModal" data-modal-toggle="deleteModal">Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
<!-- Add User Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold font-headline text-primary">Tambah Pengguna Baru</h2>
        <form id="addUserForm" class="mt-4">
            <div class="grid gap-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-name" class="text-right">Nama</label>
                    <input id="add-name" type="text" class="col-span-3 p-2 border border-gray-300 rounded-lg"
                        required />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-email" class="text-right">Email</label>
                    <input id="add-email" type="email" class="col-span-3 p-2 border border-gray-300 rounded-lg"
                        required />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-password" class="text-right">Password</label>
                    <input id="add-password" type="password" class="col-span-3 p-2 border border-gray-300 rounded-lg"
                        required />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-npm" class="text-right">NPM</label>
                    <input id="add-npm" type="text" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-role" class="text-right">Role</label>
                    <select id="add-role" class="col-span-3 p-2 border border-gray-300 rounded-lg">
                        <option value="praktikan">Praktikan</option>
                        <option value="asisten">Asisten</option>
                        <option value="pembimbing">Pembimbing</option>
                        <option value="superadmin">SuperAdmin</option>
                    </select>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="add-phone" class="text-right">Nomor Telepon</label>
                    <input id="add-phone" type="tel" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg"
                    onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Tambah Pengguna</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit User Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold font-headline text-primary">Edit Pengguna</h2>
        <form id="editUserForm" class="mt-4">
            <div class="grid gap-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="edit-name" class="text-right">Nama</label>
                    <input id="edit-name" type="text" class="col-span-3 p-2 border border-gray-300 rounded-lg"
                        required />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="edit-email" class="text-right">Email</label>
                    <input id="edit-email" type="email" class="col-span-3 p-2 border border-gray-300 rounded-lg"
                        required />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="edit-npm" class="text-right">NPM</label>
                    <input id="edit-npm" type="text" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="edit-role" class="text-right">Role</label>
                    <select id="edit-role" class="col-span-3 p-2 border border-gray-300 rounded-lg">
                        <option value="praktikan">Praktikan</option>
                        <option value="asisten">Asisten</option>
                        <option value="pembimbing">Pembimbing</option>
                        <option value="superadmin">SuperAdmin</option>
                    </select>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label for="edit-phone" class="text-right">Nomor Telepon</label>
                    <input id="edit-phone" type="tel" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg"
                    onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<!-- Delete User Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold font-headline text-primary">Konfirmasi Hapus Pengguna</h2>
        <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin menghapus pengguna <span id="deleteUserName"
                class="font-semibold"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="mt-4 flex justify-end gap-2">
            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg"
                onclick="closeModal('deleteModal')">Batal</button>
            <button type="button" class="px-4 py-2 bg-destructive text-white rounded-lg" onclick="confirmDelete()">Hapus
                Pengguna</button>
        </div>
    </div>
</div>
<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold font-headline text-primary">Reset Password</h2>
        <p class="mt-2 text-sm text-gray-600">Masukkan password baru untuk <span id="resetUserName"
                class="font-semibold"></span>. Pengguna akan diminta menggunakan password ini saat login berikutnya.</p>
        <div class="grid gap-4 mt-4">
            <div class="grid grid-cols-4 items-center gap-4">
                <label for="new-password" class="text-right">Password Baru</label>
                <input id="new-password" type="password" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
                <label for="confirm-password" class="text-right">Konfirmasi</label>
                <input id="confirm-password" type="password" class="col-span-3 p-2 border border-gray-300 rounded-lg" />
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg"
                onclick="closeModal('resetPasswordModal')">Batal</button>
            <button type="button" class="px-4 py-2 bg-primary text-white rounded-lg"
                onclick="confirmResetPassword()">Simpan Password Baru</button>
        </div>
    </div>
</div>
@endsection