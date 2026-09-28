{{-- Modal Edit Bagian --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Bagian</h3>
            <div class="mt-2 px-7 py-3">
                <input type="hidden" id="editID">
                <input type="text" id="editNama" placeholder="Nama Bagian" class="w-full border p-2 rounded mb-3">
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="updateBagian()" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Update</button>
                <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">Batal</button>
            </div>
        </div>
    </div>
</div>
