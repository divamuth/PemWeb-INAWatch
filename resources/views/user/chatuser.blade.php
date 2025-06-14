@extends('layouts.user')

@section('title', 'Chat - Ina Watch')

@section('content')
<div class="flex justify-end p-4">
    <!-- Chat Box -->
    <div class="w-[700px] bg-white shadow-lg rounded-t-[20px] rounded-b-[10px] overflow-hidden">
        <div class="flex h-[500px]">
            <!-- Chat Area -->
            <div class="flex-1">
                <div class="bg-white h-full flex flex-col relative" style="border-radius: 20px 20px 10px 10px;">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200 rounded-t-[20px]">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pastel-purple-200 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-5 w-auto">
                            </div>
                            <div>
                                <div class="font-semibold text-md" id="activeChatUser">INA Watch</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Messages Area -->
                    <div class="flex-1 p-4 overflow-y-auto" id="messagesArea">
                        <div class="space-y-3"></div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="p-4 pt-0 bg-white">
                        <div class="flex items-center space-x-3 bg-[#A3BEF6] rounded-full px-3 py-2">
                            <!-- Emoji Button -->
                            <button class="icon-btn" onclick="toggleEmojiPicker()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                </svg>
                            </button>
                            
                            <!-- Emoji Picker -->
                            <div id="emojiPicker" class="absolute bottom-16 left-4 bg-white shadow-md rounded-lg p-3 w-64 h-48 overflow-y-auto" style="display: none;">
                                <div class="emoji-grid grid grid-cols-6 gap-2" id="emojiGrid"></div>
                            </div>
                            
                            <!-- Camera Button -->
                            <button class="icon-btn" onclick="openCamera()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                            </button>
                            
                            <!-- Text Input -->
                            <input 
                                type="text" 
                                id="messageInput" 
                                placeholder="Type your message..." 
                                class="flex-1 bg-transparent text-white placeholder-white/80 focus:outline-none text-sm"
                            >
                            
                            <!-- Send Button -->
                            <button class="send-btn" onclick="sendMessage()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Camera Modal -->
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center" style="display: none;">
    <div class="bg-white rounded-lg p-4 w-[400px]">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-md font-semibold">Camera</h3>
            <button onclick="closeCamera()" class="text-gray-500 hover:text-gray-700">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <video id="cameraFeed" class="w-full rounded-md" autoplay playsinline></video>
        <canvas id="photoCanvas" style="display: none;"></canvas>
        <div class="camera-controls flex justify-between mt-3">
            <button onclick="capturePhoto()" class="bg-pastel-purple-200 text-white px-3 py-1.5 rounded-lg text-sm">
                📸 Capture Photo
            </button>
            <button onclick="closeCamera()" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm">
                ❌ Cancel
            </button>
        </div>
        <div id="cameraError" class="text-red-500 text-center mt-2 text-sm" style="display: none;">
            Camera access denied or not available
        </div>
    </div>
</div>

<script>
    let currentUserId = 1; // Default user ID for demo
    let currentUserName = 'Ina Watch';
    let cameraStream = null;
    
    // Emoji data
    const emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '☺️', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '🥴', '😵', '🤯', '🤠', '🥳', '🥸', '😎', '🤓', '🧐'];

    // Initialize emoji picker
    function initializeEmojiPicker() {
        const emojiGrid = document.getElementById('emojiGrid');
        emojis.forEach(emoji => {
            const emojiItem = document.createElement('div');
            emojiItem.className = 'emoji-item text-xl cursor-pointer hover:bg-gray-100 rounded p-1';
            emojiItem.textContent = emoji;
            emojiItem.onclick = () => insertEmoji(emoji);
            emojiGrid.appendChild(emojiItem);
        });
    }

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        
        if (message && currentUserId) {
            const messagesArea = document.getElementById('messagesArea');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-end mb-3';
            messageDiv.innerHTML = `
                <div class="bg-pastel-purple-200 p-2 rounded-xl shadow-sm max-w-[65%] text-sm">${message}</div>
            `;
            
            messagesArea.querySelector('.space-y-3').appendChild(messageDiv);
            input.value = '';
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }
    }

    function toggleEmojiPicker() {
        const picker = document.getElementById('emojiPicker');
        picker.style.display = picker.style.display === 'block' ? 'none' : 'block';
    }

    function insertEmoji(emoji) {
        const input = document.getElementById('messageInput');
        input.value += emoji;
        input.focus();
        toggleEmojiPicker();
    }

    async function openCamera() {
        const modal = document.getElementById('cameraModal');
        const video = document.getElementById('cameraFeed');
        const errorDiv = document.getElementById('cameraError');
        
        try {
            modal.style.display = 'flex';
            const constraints = {
                video: { width: { ideal: 400 }, height: { ideal: 300 }, facingMode: 'user' },
                audio: false
            };
            
            cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = cameraStream;
            
            video.onloadedmetadata = () => video.play();
            errorDiv.style.display = 'none';
        } catch (err) {
            console.error('Camera error:', err);
            errorDiv.textContent = 'Camera access denied or not available';
            errorDiv.style.display = 'block';
        }
    }

    function closeCamera() {
        const modal = document.getElementById('cameraModal');
        const video = document.getElementById('cameraFeed');
        
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        
        video.srcObject = null;
        modal.style.display = 'none';
    }

    function capturePhoto() {
        const video = document.getElementById('cameraFeed');
        const canvas = document.getElementById('photoCanvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        canvas.toBlob(function(blob) {
            if (blob && currentUserId) {
                const messagesArea = document.getElementById('messagesArea');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex justify-end mb-3';
                
                const imageUrl = URL.createObjectURL(blob);
                messageDiv.innerHTML = `
                    <div class="bg-pastel-purple-200 p-2 rounded-xl shadow-sm max-w-[65%]">
                        <img src="${imageUrl}" alt="Captured photo" class="rounded-md max-w-full h-auto mb-1">
                        <div class="text-xs">Photo sent</div>
                    </div>
                `;
                
                messagesArea.querySelector('.space-y-3').appendChild(messageDiv);
                messagesArea.scrollTop = messagesArea.scrollHeight;
                
                alert('Photo captured successfully!');
            }
            closeCamera();
        }, 'image/jpeg', 0.8);
    }

    // Enter key to send message
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Close emoji picker when clicking outside
    document.addEventListener('click', function(e) {
        const picker = document.getElementById('emojiPicker');
        const emojiBtn = e.target.closest('button[onclick="toggleEmojiPicker()"]');
        
        if (!picker.contains(e.target) && !emojiBtn) {
            picker.style.display = 'none';
        }
    });

    // Initialize
    initializeEmojiPicker();

    // Check for getUserMedia support
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        console.error('getUserMedia not supported');
    }
</script>
@endsection