@extends('layouts.user')

@section('content')
<div class="p-8">

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-full mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-full mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- @if (session('login_success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-full mb-4">
            {{ session('login_success') }}
        </div>
    @elseif (session('register_success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-full mb-4">
            {{ session('register_success') }}
        </div>
    @endif -->

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
                <a href="{{ route('user.custom', ['id' => $product->id]) }}" class="hover:brightness-95 transition">
                    <div class="bg-white rounded-[20px] shadow-md w-[290px] h-[428px] overflow-hidden flex flex-col">
                        <div class="w-full aspect-square overflow-hidden rounded-t-[20px]">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}"
                                class="w-full h-full object-cover">
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-[17px] font-semibold text-black mb-2 text-left">
                                {{ $product->product_name }}
                            </h3>
                            <span class="text-[17px] text-red-500 font-bold text-left">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-[14px] text-gray-600 text-right">
                                {{ $product->sold ?? 0 }} sold
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection