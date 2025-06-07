@extends('layouts.seller')

@section('title', 'Order')

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <div class="bg-[#FFB3F8] text-white px-10 py-3 rounded-[30px] inline-block font-bold text-lg shadow-lg">
        Order
    </div>
</div>

<!-- Input Section -->
<div class="mb-6 flex justify-between items-center">
    <!-- ID Order Input -->
    <div class="flex items-center bg-white border border-black">
        <label class="px-4 py-2 font-medium text-gray-700 border-r">ID Order:</label>
        <input type="text" id="order-id-input" placeholder="Input ID Order"
            class="px-6 py-2 border-none focus:outline-none min-w-[200px]">
    </div>

    <!-- Status Input -->
    <div class="flex items-center bg-white border border-black">
        <label class="px-5 py-2 font-medium text-gray-700 border-r">Status:</label>
        <select id="status-input" class="px-4 py-2 border-none focus:outline-none min-w-[150px] bg-white">
            <option value="">Input Status</option>
            <option value="in_packing">In Packing</option>
            <option value="delivered">Delivered</option>
            <option value="finished">Finished</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-10">
        <button onclick="saveStatus()" class="px-6 py-2 bg-white text-purple-500 font-bold border border-purple-500">
            SAVE
        </button>
        <button onclick="resetFilters()" class="px-6 py-2 bg-white text-black font-bold border border-black">
            RESET
        </button>
    </div>
</div>

<!-- Status Tabs -->
<div class="mb-6">
    <div class="flex justify-between border-b border-gray-300">
        @foreach(['all' => 'All', 'in_packing' => 'In Packing', 'delivered' => 'Delivered', 'finished' => 'Finished', 'cancelled' => 'Cancelled'] as $key => $label)
            <button class="status-tab px-4 py-2 text-black font-medium transition-colors border-b-2 border-transparent"
                    data-status="{{ $key }}" onclick="filterByStatus('{{ $key }}', event)">
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg overflow-hidden shadow-lg border-2 border-purple-200">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-purple-300 to-purple-400 text-white px-6 py-4">
        <div class="grid grid-cols-12 gap-4 font-bold">
            <div class="col-span-4">Product</div>
            <div class="col-span-2 text-center">Total</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-3 text-center">Delivery Number</div>
            <div class="col-span-1 text-center">Action</div>
        </div>
    </div>

    <!-- Orders List -->
    <div id="orders-container">
        @forelse($orders as $order)
            <div class="order-item border-b border-purple-200" data-order-id="{{ $order['id'] }}">
                <!-- Customer Info -->
                <div class="bg-purple-100 px-6 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-300 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-800">{{ $order['customer'] }}</span>
                        <span class="text-sm text-gray-600 ml-auto">ID Order: {{ $order['id'] }}</span>
                        <div class="text-sm text-gray-500">{{ now()->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <!-- Products in Order -->
                @foreach($order['products'] as $index => $product)
                <div class="px-6 py-4 {{ $index > 0 ? 'border-t border-gray-100' : '' }}" data-status="{{ $product['status'] }}">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <!-- Product Info -->
                        <div class="col-span-4 flex items-center gap-4">
                            <div class="w-16 h-16 bg-orange-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $product['name'] }}</div>
                                <div class="text-sm text-gray-500">Variasi: {{ $product['variant'] }}</div>
                                <div class="text-sm text-gray-400">{{ $product['payment_method'] }}</div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-span-2 text-center">
                            <div class="font-bold text-lg">Rp{{ number_format($product['price'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">X{{ $product['quantity'] }}</div>
                        </div>

                        <!-- Status -->
                        <div class="col-span-2 text-center">
                            @php
                                $statusConfig = [
                                    'in_packing' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'In Packing'],
                                    'delivered' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Delivered'],
                                    'finished' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Finished'],
                                    'cancelled' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled']
                                ];
                                $config = $statusConfig[$product['status']] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => ucfirst($product['status'])];
                            @endphp
                            <span class="px-3 py-1 {{ $config['class'] }} rounded-full text-sm font-medium">
                                {{ $config['text'] }}
                            </span>
                        </div>

                        <!-- Delivery Number -->
                        <div class="col-span-3 text-center">
                            <div class="font-mono text-sm text-gray-700">{{ $product['delivery_number'] }}</div>
                        </div>

                        <!-- Action -->
                        <div class="col-span-1 text-center">
                            <div class="relative">
                                <button onclick="toggleDropdown('{{ $order['id'] }}-{{ $index }}')"
                                        class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $order['id'] }}-{{ $index }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border">
                                    <div class="py-1">
                                        @if($product['status'] === 'in_packing')
                                        <button onclick="updateStatus('{{ $order['id'] }}', '{{ $index }}', 'delivered')"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Mark as Delivered
                                        </button>
                                        @endif
                                        @if($product['status'] === 'delivered')
                                        <button onclick="updateStatus('{{ $order['id'] }}', '{{ $index }}', 'finished')"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Mark as Finished
                                        </button>
                                        @endif
                                        <button onclick="viewDetails('{{ $order['id'] }}')"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @empty
            <div class="p-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-medium">Tidak ada pesanan</p>
                <p>Pesanan akan muncul di sini ketika ada pelanggan yang melakukan pemesanan</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterByStatus(status, event) {
        document.querySelectorAll('.status-tab').forEach(btn => {
            btn.classList.remove('text-pink-500', 'border-pink-500');
            btn.classList.add('text-black', 'border-transparent');
        });

        event.target.classList.remove('text-black', 'border-transparent');
        event.target.classList.add('text-pink-500', 'border-pink-500');

        document.querySelectorAll('.order-item').forEach(order => {
            const products = order.querySelectorAll('[data-status]');
            let visible = status === 'all' || [...products].some(p => p.dataset.status === status);
            order.style.display = visible ? 'block' : 'none';
        });
    }

    function saveStatus() {
        const orderId = document.getElementById('order-id-input').value;
        const newStatus = document.getElementById('status-input').value;

        if (!orderId || !newStatus) {
            alert('Please enter an Order ID and select a Status.');
            return;
        }

        fetch('/update-order-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ orderId, productIndex: 0, status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Status updated.');
                location.reload();
            } else {
                alert('Update failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error occurred.');
        });
    }

    function resetFilters() {
        document.getElementById('order-id-input').value = '';
        document.getElementById('status-input').value = '';
        filterByStatus('all', { target: document.querySelector('[data-status="all"]') });
    }

    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown-${id}`);
        dropdown.classList.toggle('hidden');

        document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
            if (d.id !== `dropdown-${id}`) {
                d.classList.add('hidden');
            }
        });
    }

    function updateStatus(orderId, productIndex, newStatus) {
        fetch('/update-order-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ orderId, productIndex, status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(`Status updated to: ${newStatus}`);
                location.reload();
            } else {
                alert('Update failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error updating status');
        });

        document.getElementById(`dropdown-${orderId}-${productIndex}`).classList.add('hidden');
    }

    function viewDetails(orderId) {
        console.log(`Viewing details for order: ${orderId}`);
        alert(`Viewing details for order: ${orderId}`);
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>
@endpush