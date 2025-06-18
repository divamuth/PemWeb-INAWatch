@extends('layouts.seller')

@section('title', 'Order')

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <div class="bg-[#FFB3F8] text-white px-10 py-3 rounded-[30px] inline-block font-bold text-lg shadow-lg">
        Order
    </div>
</div>

<!-- Status Tabs -->
<div class="mb-6">
    <div class="flex justify-between border-b border-gray-300">
        @foreach(['all' => 'All', 'in_packing' => 'In Packing', 'delivered' => 'Delivered', 'finished' => 'Finished', 'cancelled' => 'Cancelled'] as $key => $label)
            <button class="status-tab px-4 py-2 text-black font-medium transition-colors border-b-2 border-transparent hover:text-pink-500"
                    data-status="{{ $key }}" onclick="filterByStatus('{{ $key }}')">
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>

<!-- Orders List -->
<div class="space-y-6" id="orders-container">
    @forelse ($orders as $order)
        <div class="order-item border rounded-lg p-6 bg-gray-50 shadow-lg" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Order #{{ $order->id }}</h3>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        {{ $order->order_date->format('d M Y, H:i') }}
                    </span>
                    @php
                        $statusConfig = [
                            'in_packing' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'In Packing'],
                            'delivered' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Delivered'],
                            'finished' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Finished'],
                            'cancelled' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled']
                        ];
                        $config = $statusConfig[$order->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => ucfirst($order->status)];
                    @endphp
                    <span class="order-status-badge px-3 py-1 {{ $config['class'] }} rounded-full text-sm font-medium">
                        {{ $config['text'] }}
                    </span>
                </div>
            </div>

            <!-- Customer Info -->
            @if(isset($order->customer_name))
            <div class="bg-purple-100 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-300 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">{{ $order->customer_name }}</span>
                </div>
            </div>
            @endif

            <!-- Order Items Table -->
            <div class="bg-white rounded-lg overflow-hidden border">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-300 to-purple-400 text-white">
                        <tr class="text-left">
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Variation</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-center">Price</th>
                            <th class="px-4 py-3 text-center">Total</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-3 flex items-center">
                                    <img src="{{ $item->image ? asset($item->image) : asset('images/place.png') }}"                                          alt="{{ $item->product_name }}" 
                                         class="w-12 h-12 object-cover rounded mr-3">
                                    <span class="font-medium">{{ $item->product_name }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $item->product->variation ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-center">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center font-medium">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="item-status-badge px-3 py-1 {{ $config['class'] }} rounded-full text-sm font-medium">
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Summary and Actions -->
            <div class="mt-4 flex justify-between items-center">
                <div class="text-lg">
                    <strong>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
                <div class="flex items-center gap-3">
                    <select class="border rounded p-2 focus:outline-none focus:ring-2 focus:ring-purple-300" 
                            id="status-select-{{ $order->id }}">
                        <option value="in_packing" {{ $order->status == 'in_packing' ? 'selected' : '' }}>
                            In Packing
                        </option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                            Delivered
                        </option>
                        <option value="finished" {{ $order->status == 'finished' ? 'selected' : '' }}>
                            Finished
                        </option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>
                    <button onclick="updateOrderStatus({{ $order->id }})"
                            class="px-4 py-2 bg-[#FFB3F8] text-white rounded-full hover:bg-[#E59DDF] transition-colors font-medium"
                            id="update-btn-{{ $order->id }}">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-lg shadow-lg" id="empty-state">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-lg font-medium text-gray-600">Tidak ada pesanan</p>
            <p class="text-gray-500">Pesanan akan muncul di sini ketika ada pelanggan yang melakukan pemesanan</p>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
console.log('Script loaded');

// Filter function
function filterByStatus(status) {
    console.log('Filtering by status:', status);
    
    // Update tab appearance
    var tabs = document.querySelectorAll('.status-tab');
    tabs.forEach(function(tab) {
        tab.classList.remove('text-pink-500', 'border-pink-500');
        tab.classList.add('text-black', 'border-transparent');
    });
    
    var activeTab = document.querySelector('[data-status="' + status + '"]');
    if (activeTab) {
        activeTab.classList.remove('text-black', 'border-transparent');
        activeTab.classList.add('text-pink-500', 'border-pink-500');
    }
    
    // Filter orders
    var orders = document.querySelectorAll('.order-item');
    var visibleCount = 0;
    
    orders.forEach(function(order) {
        var orderStatus = order.getAttribute('data-status');
        if (status === 'all' || orderStatus === status) {
            order.style.display = 'block';
            visibleCount++;
        } else {
            order.style.display = 'none';
        }
    });
    
    console.log('Visible orders:', visibleCount);
}

// Update status function
function updateOrderStatus(orderId) {
    console.log('Updating order status for ID:', orderId);
    
    var selectElement = document.getElementById('status-select-' + orderId);
    var button = document.getElementById('update-btn-' + orderId);
    var newStatus = selectElement.value;
    
    console.log('New status:', newStatus);
    
    // Show loading
    button.textContent = 'Updating...';
    button.disabled = true;
    
    // Make AJAX request
    fetch('/update-order-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            orderId: orderId,
            status: newStatus
        })
    })
    .then(function(response) {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(function(data) {
        console.log('Response data:', data);
        
        if (data.success) {
            // Update the order status in DOM
            updateOrderStatusInDOM(orderId, newStatus);
            alert('Status berhasil diupdate!');
        } else {
            throw new Error(data.message || 'Update gagal');
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    })
    .finally(function() {
        // Reset button
        button.textContent = 'Update Status';
        button.disabled = false;
    });
}

function updateOrderStatusInDOM(orderId, newStatus) {
    console.log('Updating DOM for order:', orderId, 'status:', newStatus);
    
    var orderElement = document.querySelector('[data-order-id="' + orderId + '"]');
    if (!orderElement) {
        console.error('Order element not found');
        return;
    }
    
    // Update data attribute
    orderElement.setAttribute('data-status', newStatus);
    
    // Define status configs
    var statusConfigs = {
        'in_packing': { class: 'bg-yellow-100 text-yellow-800', text: 'In Packing' },
        'delivered': { class: 'bg-green-100 text-green-800', text: 'Delivered' },
        'finished': { class: 'bg-blue-100 text-blue-800', text: 'Finished' },
        'cancelled': { class: 'bg-red-100 text-red-800', text: 'Cancelled' }
    };
    
    var config = statusConfigs[newStatus] || { class: 'bg-gray-100 text-gray-800', text: newStatus };
    
    // Update header badge
    var headerBadge = orderElement.querySelector('.order-status-badge');
    if (headerBadge) {
        headerBadge.className = 'order-status-badge px-3 py-1 ' + config.class + ' rounded-full text-sm font-medium';
        headerBadge.textContent = config.text;
    }
    
    // Update all item badges
    var itemBadges = orderElement.querySelectorAll('.item-status-badge');
    itemBadges.forEach(function(badge) {
        badge.className = 'item-status-badge px-3 py-1 ' + config.class + ' rounded-full text-sm font-medium';
        badge.textContent = config.text;
    });
    
    console.log('DOM updated successfully');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');
    
    // Set "All" tab as active by default
    filterByStatus('all');
    
    console.log('Initialization complete');
});
</script>
@endpush