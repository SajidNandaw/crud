<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal {
            transition: all 0.25s ease-in-out;
            opacity: 0;
            transform: scale(0.95);
        }
        .modal.show {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

<!-- Header -->
<header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg text-white">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold tracking-wide">CRUD</h1>
        <button onclick="openModal('createModal')"
            class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg font-medium transition">
            + Add Product
        </button>
    </div>
</header>

<!-- Main Container -->
<main class="max-w-6xl mx-auto mt-10 px-6">

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Product List</h2>
            <p class="text-sm text-gray-500">{{ $products->count() }} products total</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                        <th class="py-3 px-4 text-left rounded-tl-lg">No</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-right rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $i => $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $i + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button onclick="showDetails('{{ addslashes($product->name) }}', '{{ addslashes($product->details) }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow-sm">
                                View
                            </button>

                            <button onclick="editProduct({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->details) }}')"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow-sm">
                                Edit
                            </button>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-gray-500 italic">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</main>

<!-- Modal Overlay -->
<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm z-40"></div>

<!-- Modal Create -->
<div id="createModal" class="hidden fixed inset-0 z-50 flex justify-center items-center">
    <div class="modal bg-white w-96 rounded-xl shadow-2xl p-6 relative">
        <button onclick="closeModal('createModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Add Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Product Name"
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <textarea name="details" placeholder="Details"
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
            <div class="text-right space-x-2">
                <button type="button" onclick="closeModal('createModal')"
                    class="px-3 py-1 border rounded-lg hover:bg-gray-100">Cancel</button>
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-1 rounded-lg hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 z-50 flex justify-center items-center">
    <div class="modal bg-white w-96 rounded-xl shadow-2xl p-6 relative">
        <button onclick="closeModal('editModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Product</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input id="editName" type="text" name="name"
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <textarea id="editDetails" name="details"
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
            <div class="text-right space-x-2">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-3 py-1 border rounded-lg hover:bg-gray-100">Cancel</button>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="hidden fixed inset-0 z-50 flex justify-center items-center">
    <div class="modal bg-white w-96 rounded-xl shadow-2xl p-6 relative">
        <button onclick="closeModal('detailModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Product Details</h2>
        <p><span class="font-semibold">Name:</span> <span id="detailName" class="text-gray-700"></span></p>
        <p class="mt-2"><span class="font-semibold">Details:</span></p>
        <p id="detailText" class="text-gray-600 mt-1"></p>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById('overlay').classList.remove('hidden');
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    setTimeout(() => modal.querySelector('.modal').classList.add('show'), 10);
}

function closeModal(id) {
    const modal = document.getElementById(id);
    const box = modal.querySelector('.modal');
    box.classList.remove('show');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('overlay').classList.add('hidden');
    }, 150);
}

function editProduct(id, name, details) {
    document.getElementById('editForm').action = '/products/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editDetails').value = details;
    openModal('editModal');
}

function showDetails(name, details) {
    document.getElementById('detailName').textContent = name;
    document.getElementById('detailText').textContent = details;
    openModal('detailModal');
}

function confirmDelete(button) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        button.closest('form').submit();
    }
}
</script>

</body>
</html>
