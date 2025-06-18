@extends('layouts.user')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 min-h-screen bg-gray-50">
        <div class="p-6 flex justify-center">
            <nav class="space-y-3 w-full">
                <a href="/user/profile" class="sidebar-link {{ request()->is('user/profile') ? 'active' : '' }}">
                    Profile
                </a>
                <a href="/user/address" class="sidebar-link {{ request()->is('user/address') ? 'active' : '' }}">
                    Address
                </a>
                <a href="/user/order" class="sidebar-link {{ request()->is('user/order*') ? 'active' : '' }}">
                    Order
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 pt-2 pl-8 m-4">
        <div class="flex pl-8 items-center">
            <img src="{{ asset('images/profile-gray.png') }}" alt="Profile" class="h-8 w-8"> 
            <strong class="text-xl pl-4">{{ Auth::user()->name }}</strong>
        </div>

        <div class="p-8 bg-white shadow-lg rounded-[30px] m-4">
            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-6">
                <button onclick="filterOrders('all')" 
                        class="filter-btn px-5 py-2 rounded-full font-bold shadow-md transition-all bg-[#FFB3F8] text-white hover:bg-[#E59DDF] active">All</button>
                <button onclick="filterOrders('In Packing')" 
                        class="filter-btn px-5 py-2 rounded-full font-bold shadow-md transition-all bg-[#FFB3F8] text-white hover:bg-[#E59DDF]">In Packing</button>
                <button onclick="filterOrders('Delivered')" 
                        class="filter-btn px-5 py-2 rounded-full font-bold shadow-md transition-all bg-[#FFB3F8] text-white hover:bg-[#E59DDF]">Delivered</button>
                <button onclick="filterOrders('Finished')" 
                        class="filter-btn px-5 py-2 rounded-full font-bold shadow-md transition-all bg-[#FFB3F8] text-white hover:bg-[#E59DDF]">Finished</button>
                <button onclick="filterOrders('Cancelled')" 
                        class="filter-btn px-5 py-2 rounded-full font-bold shadow-md transition-all bg-[#FFB3F8] text-white hover:bg-[#E59DDF]">Cancelled</button>
            </div>
            
            <!-- Orders Container -->
            <div id="orders-container">
                @include('user.orders-list', ['orders' => $orders])
            </div>
        </div>
    </div>
</div>

<style>
    .sidebar-link {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 12px 16px;
        color: white;
        border-radius: 30px;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s;
        font-size: 20px;
        background-color: #CFDEFE;
    }
    .sidebar-link:hover {
        background-color: #A3BEF6;
        transform: scale(1.05);
    }
    .sidebar-link.active {
        background-color: #A3BEF6;
    }
    .filter-btn.active {
        background-color: #E59DDF !important;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Current active filter
let currentFilter = 'all';

function filterOrders(status) {
    // Skip if already active
    if (status === currentFilter) return;
    
    // Update current filter
    currentFilter = status;
    
    // Update active button
    $('.filter-btn').removeClass('active');
    $(`button[onclick="filterOrders('${status}')"]`).addClass('active');
    
    // Show loading
    $('#orders-container').html(`
        <div class="text-center py-10">
            <div class="inline-block w-8 h-8 border-4 border-[#FFB3F8] border-t-[#E59DDF] rounded-full animate-spin"></div>
            <p class="mt-3 text-gray-600">Loading orders...</p>
        </div>
    `);
    
    // AJAX request
    $.ajax({
        url: "{{ route('user.orders.filter') }}",
        type: "GET",
        data: { 
            status: status
        },
        success: function(response) {
            $('#orders-container').html(response.html);
        },
        error: function(xhr) {
            let errorMessage = 'Error loading orders';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            $('#orders-container').html(`
                <div class="text-center py-10 text-red-500">
                    <p>${errorMessage}</p>
                    <button onclick="filterOrders('${status}')" 
                        class="mt-3 px-4 py-2 bg-[#FFB3F8] text-white rounded-full hover:bg-[#E59DDF]">
                        Try Again
                    </button>
                </div>
            `);
        }
    });
}

// Initialize on page load
$(document).ready(function() {
    // Set active sidebar
    $('.sidebar-link').removeClass('active');
    $('.sidebar-link[href="/user/order"]').addClass('active');
    
    // Set active filter button
    $('.filter-btn').removeClass('active');
    $('.filter-btn:contains("All")').addClass('active');
});
</script>
@endsection