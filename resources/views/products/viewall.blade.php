<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg text-white">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

            <h1 class="text-2xl font-bold">All Products</h1>

            <a href="{{ route('products.index') }}"
                class="bg-white text-blue-700 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
                Back
            </a>

        </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto mt-10 px-6">

        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">All Products</h2>
                <p class="text-sm text-gray-500">{{ $products->count() }} total products</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                            <th class="py-3 px-4 text-left">No</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $i => $product)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4">{{ $i + 1 }}</td>
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-gray-700">{{ $product->details }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-gray-500 italic">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-10 py-6 text-center text-gray-500 text-sm">
        © 2025 CodeVibe — All Rights Reserved.
        <br>
        (Williams, Sajid, Vino, Syifa, Shofi)
    </footer>
</body>

</html>
