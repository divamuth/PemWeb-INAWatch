@extends('layouts.seller')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
body {
    font-family: "Inter", sans-serif;
}
</style>

<div class="flex w-full">
    <!-- Konten utama -->
    <div class="flex-1 bg-white rounded-2xl shadow p-4 m-4">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-6 flex justify-between items-center">
            <div class="bg-[#FFB3F8] text-white px-10 py-3 rounded-[30px] inline-block font-bold text-lg shadow-lg">
                Stock
            </div>
            <button type="button" onclick="openAddPopup()" class="bg-[#FFB3F8] text-white px-10 py-3 rounded-[30px] inline-block font-bold text-lg shadow-lg">
                Add Product
            </button>
        </div>

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-purple-300 to-purple-400 text-white font-bold px-6 py-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">Product</div>
                <div class="col-span-2 text-center">Sale</div>
                <div class="col-span-2 text-center">Price</div>
                <div class="col-span-3 text-center">Stock</div>
                <div class="col-span-1 text-center">Action</div>
            </div>
        </div>

        <!-- ROW -->
        @forelse($products as $product)
        <div class="border-b px-6 py-4">
            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-4 flex items-center gap-2">
                    <img id="" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="h-40 rounded-md object-cover">
                    <div>
                        <div class="font-semibold">{{ $product->product_name }}</div>
                        <div class="text-gray-500 text-xs">Varian: {{ $product->variation }}</div>
                    </div>
                </div>
                <div class="col-span-2 text-center">{{ $product->sale }}</div>
                <div class="col-span-2 text-center">{{ $product->price }}</div>
                <div class="col-span-3 text-center">{{ $product->stock }}</div>
                <div class="col-span-1 text-center text-red-500">
                    <button type="button" onclick="openEditPopup({{ $product->id }})" class="mr-2 underline">
                        Edit
                    </button>
                    <br>
                    <button type="button" onclick="openDeletePopup({{ $product->id }}, '{{ $product->product_name }}', '{{ $product->variation }}', '{{ $product->image ? (str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/'.$product->image)) : asset('images/contoh2.png') }}')" class="mr-2 underline">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            No products found. Add your first product!
        </div>
        @endforelse
    </div>

    {{-- Add Pop Up --}}
    <div id="addPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <strong class="text-xl">Add Product</strong>
                <button type="button" onclick="openAddPopup('addPopup')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="addForm" action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex gap-8">
                    <!-- Gambar Produk -->
                    <div class="bg-white rounded-xl border p-4 flex justify-center items-center relative w-1/3">
                        <img id="addPreviewImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="h-40 rounded-md object-cover">
                        <input type="file" id="addImageInput" name="image" accept="image/*" class="hidden" onchange="previewImage('addImageInput', 'addPreviewImage')">
                        <div class="absolute bottom-2 right-2 flex space-x-2">
                            <button type="button" onclick="document.getElementById('addImageInput').click()" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form Input -->
                    <div class="w-2/3">
                        <div class="space-y-4 w-full">
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Product Name<span class="text-red-500">*</span></label>
                                <input type="text" name="product_name" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Variation<span class="text-red-500">*</span></label>
                                <input type="text" name="variation" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Sale<span class="text-red-500">*</span></label>
                                <input type="text" name="sale" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Price<span class="text-red-500">*</span></label>
                                <input type="text" name="price" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Stock<span class="text-red-500">*</span></label>
                                <input type="number" name="stock" min="0" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-10 py-3 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Pop Up --}}
    <div id="editPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <strong class="text-xl">Edit Product</strong>
                <button type="button" onclick="closePopup('editPopup')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex gap-8">
                    <!-- Gambar Produk -->
                    <div class="bg-white rounded-xl border p-4 flex justify-center items-center relative w-1/3">
                        <img id="editPreviewImage" src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="max-h-96 object-contain" />
                        <input type="file" id="editImageInput" name="image" accept="image/*" class="hidden" onchange="previewImage('editImageInput', 'editPreviewImage')">
                        <div class="absolute bottom-2 right-2 flex space-x-2">
                            <button type="button" onclick="document.getElementById('editImageInput').click()" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form Input -->
                    <div class="w-2/3">
                        <div class="space-y-4 w-full">
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Product Name<span class="text-red-500">*</span></label>
                                <input type="text" id="editProductName" name="product_name" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Variation<span class="text-red-500">*</span></label>
                                <input type="text" id="editVariation" name="variation" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Sale<span class="text-red-500">*</span></label>
                                <input type="text" id="editSale" name="sale" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Price<span class="text-red-500">*</span></label>
                                <input type="text" id="editPrice" name="price" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                            <div class="flex flex-col mb-2">
                                <label class="text-gray-400 text-lg font-semibold pl-2">Stock<span class="text-red-500">*</span></label>
                                <input type="number" id="editStock" name="stock" min="0" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-10 py-3 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Pop Up --}}
    <div id="deletePopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-[28rem]">
            <div class="flex gap-4 items-center">
                <img id="deleteProductImage" src="{{ asset('images/contoh2.png') }}" alt="Product Image" class="h-40 object-cover rounded-md">
                <div>
                    <p id="deleteProductName" class="font-bold text-lg leading-tight"></p>
                    <p id="deleteProductVariation" class="text-gray-400 text-sm mt-1"></p>
                </div>
            </div>
            <p class="text-center mt-6 mb-4">Are you sure you want to delete this item?</p>
            <div class="flex gap-4">
                <button onclick="closePopup('deletePopup')" class="flex-1 bg-gray-200 text-gray-600 font-semibold py-2 rounded-full hover:bg-gray-300">Cancel</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-purple-400 text-white font-semibold py-2 rounded-full hover:bg-purple-500">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openAddPopup() {
        // Reset form
        const form = document.getElementById('addForm');
        const previewImg = document.getElementById('addPreviewImage');
        const inputFile = document.getElementById('addImageInput');

        form.reset();
        inputFile.value = ''; // clear input file (jaga-jaga)
        previewImg.src = '';  // clear preview supaya user tahu belum ada gambar

        document.getElementById('addPopup').classList.remove('hidden');   
    }

    function previewImage(inputId, imgId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openEditPopup(productId) {
        console.log('Opening edit popup for product ID:', productId);
        fetch(`/seller/stock/${productId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(product => {
                console.log('Product data:', product);
                if (!product || !product.product_name) throw new Error('Invalid product data');

                document.getElementById('editForm').action = `/seller/stock/${product.id}`;
                console.log('Form action set to:', document.getElementById('editForm').action);

                document.getElementById('editProductName').value = product.product_name;
                document.getElementById('editVariation').value = product.variation;
                document.getElementById('editSale').value = product.sale;
                document.getElementById('editPrice').value = product.price;
                document.getElementById('editStock').value = product.stock;
                
                // Set image
                const imageUrl = product.image ? 
                    (product.image.startsWith('images/') ? 
                        `/images/${product.image.split('images/')[1]}` : 
                        `/storage/${product.image}`) : 
                    "/images/contoh2.png";
                console.log('Image URL:', imageUrl);
                document.getElementById('editPreviewImage').src = imageUrl;

                // Show popup
                const editPopup = document.getElementById('editPopup');
                console.log('editPopup element:', editPopup);
                if (!editPopup) throw new Error('editPopup element not found');
                editPopup.classList.remove('hidden');
                console.log('editPopup classes:', editPopup.className);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading product data' + error.message);
            });
    }

    function openDeletePopup(productId, productName, variation, imageUrl) {
        document.getElementById('deleteForm').action = "{{ route('stock.destroy', ':id') }}".replace(':id', productId);
        document.getElementById('deleteProductName').textContent = productName;
        document.getElementById('deleteProductVariation').textContent = `Variasi: ${variation}`;
        document.getElementById('deleteProductImage').src = imageUrl;
        document.getElementById('deletePopup').classList.remove('hidden');
    }

    function closePopup(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function previewImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('click', function (e) {
        ['addPopup', 'editPopup', 'deletePopup'].forEach(id => {
            const popup = document.getElementById(id);
            if (e.target === popup) {
                closePopup(id);
            }
        });
    });
    </script>
@endsection