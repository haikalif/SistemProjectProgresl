{{-- Modal Tambah Bagian --}}
<div id="modalAdd" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Bagian</h3>
            <div class="mt-2 px-7 py-3">
                <input type="text" id="addNama" placeholder="Nama Bagian" class="w-full border p-2 rounded mb-3">
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="createBagian()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                <button onclick="closeAddModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">Batal</button>
            </div>
        </div>
    </div>
</div>
