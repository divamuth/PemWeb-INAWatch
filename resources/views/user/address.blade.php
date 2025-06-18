@extends('layouts.user')

@section('content')
<div class="flex">
    <div class="w-64 min-h-screen">
        <div class="p-6 flex justify-center">
            <nav class="space-y-3 w-full">
                <a href="/user/profile" class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl {{ request()->is('user/profile') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">Profile</a>
                <a href="/user/address" class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl {{ request()->is('user/address') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">Address</a>
                <a href="/user/order" class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl {{ request()->is('user/order') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">Order</a>
            </nav>
        </div>
    </div>

    <div class="flex-1 pt-2 pl-8 m-4">
        <div class="flex pl-8">
            <strong class="text-xl pl-4 pt-1">My Addresses</strong>
        </div>

        <div class="flex-1 p-8 bg-white shadow-lg rounded-[30px] m-4">
            <div class="flex justify-end pr-5">
                <button type="button" onclick="openPopup()" class="px-6 py-2 bg-[#CBA3F6] text-white rounded-full hover:bg-purple-400 font-bold hover:scale-105 transform transition-all duration-200">+ Add New Addresses</button>
            </div>

            @foreach ($addresses as $address)
                <div class="bg-pastel-pink-200 m-4 border border-gray-300 rounded-[30px] p-5 text-md">
                    <strong>{{ $address->category }}</strong><br>
                    <strong>{{ $address->name }}</strong>
                    <p class="font-semibold">{{ $address->phone }}</p>
                    <p class="text-gray-400">{{ $address->address_detail }}</p>
                    <p class="text-gray-400">{{ strtoupper($address->district) }}, {{ strtoupper($address->city) }}, {{ strtoupper($address->province) }}, {{ $address->post }}</p>

                    <div class="flex justify-end space-x-2 mt-2">
                        <button onclick='openEditPopup(@json($address))' class="px-3 py-1 bg-yellow-400 text-white rounded-full hover:bg-yellow-500 text-sm font-bold">Edit</button>
                        <form action="{{ route('user.address.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 text-sm font-bold">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="addressPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-auto">
        <strong class="flex mb-4 text-xl" id="popupTitle">New Address</strong>
        <form id="addressForm" method="POST" action="{{ route('user.address.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">Category<span style="color: red;">*</span></label>
                <input type="text" name="category" id="category" class="input-style" required>
            </div>
            <div class="flex justify-between space-x-4 mb-2">
                <div class="flex flex-col w-1/2">
                    <label class="text-gray-400 text-lg font-semibold pl-2">Name<span style="color: red;">*</span></label>
                    <input type="text" name="name" id="name" class="input-style w-full" required>
                </div>
                <div class="flex flex-col w-1/2">
                    <label class="text-gray-400 text-lg font-semibold pl-2">Phone<span style="color: red;">*</span></label>
                    <input type="text" name="phone" id="phone" class="input-style w-full" required>
                </div>
            </div>
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">Province<span style="color: red;">*</span></label>
                <input type="text" name="province" id="province" class="input-style" required>
            </div>
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">City<span style="color: red;">*</span></label>
                <input type="text" name="city" id="city" class="input-style" required>
            </div>
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">District<span style="color: red;">*</span></label>
                <input type="text" name="district" id="district" class="input-style" required>
            </div>
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">Post<span style="color: red;">*</span></label>
                <input type="number" name="post" id="post" class="input-style" required>
            </div>
            <div class="flex flex-col mb-2">
                <label class="text-gray-400 text-lg font-semibold pl-2">Detail</label>
                <input type="text" name="address_detail" id="address_detail" class="input-style">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closePopup()" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-save">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPopup() {
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            document.querySelector('input[name="_token"]').value = data.csrf_token;
        });

    document.getElementById('popupTitle').innerText = 'New Address';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('addressForm').action = '{{ route('user.address.store') }}';
    document.querySelectorAll('#addressForm input').forEach(el => el.value = '');
    document.getElementById('addressPopup').classList.remove('hidden');
}

function openEditPopup(address) {
    document.getElementById('popupTitle').innerText = 'Edit Address';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('addressForm').action = `/user/address/${address.id}`;
    document.getElementById('category').value = address.category;
    document.getElementById('name').value = address.name;
    document.getElementById('phone').value = address.phone;
    document.getElementById('province').value = address.province;
    document.getElementById('city').value = address.city;
    document.getElementById('district').value = address.district;
    document.getElementById('post').value = address.post;
    document.getElementById('address_detail').value = address.address_detail;
    document.getElementById('addressPopup').classList.remove('hidden');
}

function closePopup() {
    document.getElementById('addressPopup').classList.add('hidden');
    document.querySelectorAll('#addressForm input').forEach(el => {
        if (el.name !== '_token' && el.name !== '_method') {
            el.value = '';
        }
    });

}
</script>

<style>
.input-style {
    background-color: white;
    height: 2rem;
    border: 1px solid #ccc;
    border-radius: 9999px;
    padding-left: 1rem;
    outline: none;
    transition: 0.2s;
}
.input-style:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 2px #ddd6fe;
}
.btn-cancel, .btn-save {
    padding: 0.5rem 1.5rem;
    border-radius: 9999px;
    font-weight: bold;
    transition: 0.2s;
}
.btn-cancel {
    background-color: #9ca3af;
    color: white;
}
.btn-save {
    background-color: #A3A4F6;
    color: white;
}
.btn-cancel:hover { background-color: #6b7280; transform: scale(1.05); }
.btn-save:hover { background-color: #818cf8; transform: scale(1.05); }
</style>
@endsection
