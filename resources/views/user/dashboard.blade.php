@extends('layouts.user')

@section('content')
<div class="p-8">

    @if ($products->isEmpty())
        <p class="text-gray-600">
            @if ($search)
                No products found for "{{ $search }}".
            @else
                No products available at the moment.
            @endif
        </p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-[20px] shadow-md w-[290px] h-[428px] overflow-hidden flex flex-col">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-[258px] h-[257px] object-cover mx-auto mt-4 rounded-lg">
                    
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <h3 class="text-[18px] font-semibold text-black mb-2">{{ $product->name }}</h3>
                        <div class="flex justify-between items-end mt-auto">
                            <span class="text-[18px] text-red-500 font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-[14px] text-gray-600">{{ $product->sold }} terjual</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection