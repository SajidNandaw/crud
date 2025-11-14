<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<!-- Header -->
<header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg text-white">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

        <h1 class="text-2xl font-bold">CRUD</h1>

        <div class="flex items-center gap-3">
            <!-- Tombol View All -->
            <a href="{{ route('products.viewall') }}"
                class="bg-white text-blue-700 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
                View All
            </a>

            <!-- Tombol Add Product -->
            <button onclick="openModal('createModal')"
                class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg font-medium transition">
                + Add Product
            </button>
        </div>

    </div>
</header>

<!-- Main -->
<main class="max-w-6xl mx-auto mt-10 px-6">

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-2xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Product List</h2>
            <p class="text-sm text-gray-500">{{ $products->count() }} total products</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $i => $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $i + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('products.show', $product->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow-sm">
                                View
                            </a>
                            <button 
                                onclick="editProduct({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->details) }}')"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow-sm">
                                Edit
                            </button>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button
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

<!-- Overlay -->
<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm z-40"></div>

<!-- Modal Create -->
<div id="createModal" class="hidden fixed inset-0 z-50 flex justify-center items-center">
    <div class="bg-white w-96 rounded-xl shadow-2xl p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Add Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Product Name" required
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <textarea name="details" placeholder="Details" required
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
    <div class="bg-white w-96 rounded-xl shadow-2xl p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Product</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input id="editName" type="text" name="name" required
                class="w-full border p-2 mb-3 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <textarea id="editDetails" name="details" required
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

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById('overlay').classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById('overlay').classList.add('hidden');
}

function editProduct(id, name, details) {
    openModal('editModal');
    document.getElementById('editName').value = name;
    document.getElementById('editDetails').value = details;
    document.getElementById('editForm').action = '/products/' + id;
}
</script>

<!-- Footer -->
<footer class="mt-10 py-6 text-center text-gray-500 text-sm">
    © 2025 CodeVibe — All Rights Reserved.
            <br>
        (Williams, Sajid, Vino, Syifa, Shofi)
</footer>

</body>
</html>
