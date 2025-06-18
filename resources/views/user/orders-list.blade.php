@forelse ($orders as $order)
<div class="my-4 border border-gray-300 rounded-[30px] p-5 text-md relative mt-6">
    <div class="flex flex-row">
        <p class="font-bold ml-4 mr-10">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
        <p class="text-sm py-0.5 px-4 rounded-full shadow-md 
            {{ $order->status === 'Finished' ? 'bg-green-200 text-green-700' : 
               ($order->status === 'Cancelled' ? 'bg-gray-200 text-gray-700' : 
               ($order->status === 'Delivered' ? 'bg-blue-200 text-blue-700' : 'bg-yellow-200 text-yellow-700')) }}">
            {{ $order->status }}
        </p>
    </div>

    @foreach ($order->items as $item)
    <div class="flex flex-row my-4">
        <img src="{{ $item->image ? asset($item->image) : asset('images/contoh1.png') }}" 
             alt="{{ $item->product_name }}" 
             class="h-28 mx-12 object-cover rounded-lg">
        <div>
            <p class="w-64 font-medium">{{ $item->product_name }}</p>
            <p class="text-sm text-gray-400">Variation: {{ $item->product->variation ?? '-' }}</p>
            <p class="text-sm text-gray-400">Strap: {{ $item->selected_strap ?? '-' }}</p>
            <p class="text-gray-600">x{{ $item->quantity }}</p>
        </div>
        <div class="ml-auto text-right">
            <p class="text-sm text-gray-500">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
        </div>
    </div>
    @endforeach

    <div class="absolute bottom-5 right-5">
        <p class="text-sm text-gray-400">Total Order:</p>
        <p class="font-bold text-lg">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>
</div>
@empty
<div class="text-center py-10">
    <p class="text-gray-500 text-xl">No orders found</p>
    <a href="{{ route('user.dashboard') }}" 
       class="inline-block mt-4 bg-[#FFB3F8] text-white px-6 py-2 rounded-full hover:bg-[#E59DDF]">
        Start Shopping
    </a>
</div>
@endforelse