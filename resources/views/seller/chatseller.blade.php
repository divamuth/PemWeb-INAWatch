<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Ina Watch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-blue-200': '#c5d7f9',
                        'pastel-purple-200': '#dfc6fa',
                        'pastel-pink-200': '#ffd8fb',
                    }
                }
            }
        }
    </script>
    <style>
        .seller-gradient {
            background: linear-gradient(135deg, #E59DDF 0%, #FFB3F8 100%);
        }
        .user-gradient {
            background: linear-gradient(135deg, #CBA3F6 0%, #A3A4F6 100%);
        }
        .seller-corner {
            border-radius: 25px 25px 25px 5px;
        }
        .user-corner {
            border-radius: 25px 25px 5px 25px;
        }
        .chat-input-container {
            background-color: #A3BEF6;
            border-radius: 35px;
            height: 82px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 15px;
        }
        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .icon-btn:hover {
            transform: scale(1.1);
        }
        .send-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .send-btn:hover {
            transform: scale(1.1);
        }
        .send-btn svg {
            fill: #A3BEF6;
        }
        .emoji-picker {
            position: absolute;
            bottom: 100px;
            left: 20px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
            width: 300px;
            max-height: 200px;
            overflow-y: auto;
        }
        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
        }
        .emoji-item {
            padding: 8px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.2s;
            font-size: 18px;
        }
        .emoji-item:hover {
            background-color: #f0f0f0;
        }
        .camera-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .camera-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
        }
        .camera-feed {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            background: #f0f0f0;
        }
        .camera-controls {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .camera-controls button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
        }
        .capture-btn {
            background-color: #4CAF50;
            color: white;
        }
        .cancel-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-b from-pastel-blue-200 via-pastel-purple-200 to-pastel-pink-200 p-6">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center ml-12">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
            <div class="flex gap-4">
                <a href="/seller/dashboard" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('seller/dashboard') || request()->is('seller') ? 'images/home-black.png' : 'images/home-white.png') }}" alt="Home" class="h-8 w-8">
                </a>
                <a href="/seller/chatseller" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('seller/chatseller') || request()->is('seller') ? 'images/chat-black.png' : 'images/chat-white.png') }}" alt="Chat" class="h-8 w-8">
                </a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-gradient-to-b from-pastel-pink-200 via-pastel-purple-200 to-pastel-blue-200" style="height: calc(100vh - 112px);">
        <div class="flex h-full">
            <!-- Sidebar -->
            <div class="w-80 p-6 flex flex-col">
                <!-- Search -->
                <div class="relative mb-4">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Search Chat or Account" 
                        class="w-full px-4 py-3 pr-12 rounded-lg bg-white/80 backdrop-blur border-0 focus:outline-none focus:ring-2 focus:ring-white"
                    >
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- User List -->
                <div class="flex-1 overflow-y-auto">
                    <ul id="userList" class="space-y-3">
                        @foreach($users ?? [] as $user)
                        <li class="user-item">
                            <a href="#" onclick="selectUser('{{ $user->id }}', '{{ $user->name }}')" 
                               class="flex items-center p-3 bg-white/60 backdrop-blur rounded-2xl hover:bg-white/80 transition-all">
                                <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-800">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $user->email ?? 'No recent message' }}</div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $user->updated_at ? $user->updated_at->format('H:i') : '00:00' }}
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div id="noResults" class="text-center text-gray-600 mt-8 hidden">
                        No chats found matching your search.
                    </div>
                </div>
            </div>
            
            <!-- Chat Area -->
            <div class="flex-1 pl-0">
            <div class="bg-white h-full flex flex-col relative" style="border-radius: 30px 0 0 0;">
                    <!-- Chat Header -->
                    <div class="p-6 border-b border-gray-200 rounded-t-3xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white font-semibold mr-4">
                                <span id="activeChatInitial">?</span>
                            </div>
                            <div>
                                <div class="font-semibold text-lg" id="activeChatUser">Select a user to start chatting</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Messages Area -->
                    <div class="flex-1 p-6 overflow-y-auto" id="messagesArea">
                        <div class="text-center text-gray-500 mt-20">
                            Select a user from the sidebar to view messages
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="p-6 pt-0 relative">
                        <div class="flex justify-center">
                            <div class="chat-input-container relative" style="width: 900px;">
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="emoji-picker">
                                    <div class="emoji-grid" id="emojiGrid">
                                        <!-- Emojis will be populated by JavaScript -->
                                    </div>
                                </div>
                                
                                <!-- Emoji Button -->
                                <button class="icon-btn" onclick="toggleEmojiPicker()">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                    </svg>
                                </button>
                                
                                <!-- Text Input -->
                                <input 
                                    type="text" 
                                    id="messageInput" 
                                    placeholder="Type your message..." 
                                    class="flex-1 bg-transparent text-white placeholder-white/80 focus:outline-none text-lg"
                                >
                                
                                <!-- Camera Button -->
                                <button class="icon-btn" onclick="openCamera()">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                        <circle cx="12" cy="13" r="4"></circle>
                                    </svg>
                                </button>
                                
                                <!-- Send Button -->
                                <button class="send-btn" onclick="sendMessage()">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
    <div id="cameraModal" class="camera-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
        <div class="camera-container bg-white rounded-lg p-6 w-[500px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Camera</h3>
                <button onclick="closeCamera()" class="text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <video id="cameraFeed" class="camera-feed w-full rounded-lg" autoplay playsinline></video>
            <canvas id="photoCanvas" style="display: none;"></canvas>
            <div class="camera-controls flex justify-between mt-4">
                <button onclick="capturePhoto()" class="capture-btn bg-pastel-purple-200 text-white px-4 py-2 rounded-lg">
                    📸 Capture Photo
                </button>
                <button onclick="closeCamera()" class="cancel-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                    ❌ Cancel
                </button>
            </div>
            <div id="cameraError" class="text-red-500 text-center mt-2" style="display: none;">
                Camera access denied or not available
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;
        let currentUserName = '';
        let cameraStream = null;
        
        // Emoji data
        const emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '☺️', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '🥴', '😵', '🤯', '🤠', '🥳', '🥸', '😎', '🤓', '🧐'];

        // Initialize emoji picker
        function initializeEmojiPicker() {
            const emojiGrid = document.getElementById('emojiGrid');
            emojis.forEach(emoji => {
                const emojiItem = document.createElement('div');
                emojiItem.className = 'emoji-item';
                emojiItem.textContent = emoji;
                emojiItem.onclick = () => insertEmoji(emoji);
                emojiGrid.appendChild(emojiItem);
            });
        }

        function selectUser(userId, userName) {
            currentUserId = userId;
            currentUserName = userName;
            document.getElementById('activeChatUser').textContent = userName;
            document.getElementById('activeChatInitial').textContent = userName.charAt(0).toUpperCase();
            loadMessages(userId);
        }

        function loadMessages(userId) {
            // In real implementation, this would fetch from your Laravel backend
            const messagesArea = document.getElementById('messagesArea');
            messagesArea.innerHTML = `
                <div class="space-y-4">
                    <div class="text-center text-gray-500 mt-20">
                        No messages yet. Start the conversation!
                    </div>
                </div>
            `;
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message && currentUserId) {
                const messagesArea = document.getElementById('messagesArea');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex justify-end mb-4';
                messageDiv.innerHTML = `
                    <div class="seller-gradient seller-corner text-white px-4 py-3 max-w-md">
                        ${message}
                    </div>
                `;
                
                if (messagesArea.querySelector('.text-center')) {
                    messagesArea.innerHTML = '<div class="space-y-4"></div>';
                }
                
                messagesArea.querySelector('.space-y-4').appendChild(messageDiv);
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
            document.getElementById('emojiPicker').style.display = 'none';
        }

        async function openCamera() {
            const modal = document.getElementById('cameraModal');
            const video = document.getElementById('cameraFeed');
            const errorDiv = document.getElementById('cameraError');
            
            try {
                // Show modal first
                modal.style.display = 'flex';
                
                // Request camera access with specific constraints
                const constraints = {
                    video: {
                        width: { ideal: 640 },
                        height: { ideal: 480 },
                        facingMode: 'user' // Front camera
                    },
                    audio: false
                };
                
                cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = cameraStream;
                
                // Wait for video to load
                video.onloadedmetadata = function() {
                    video.play();
                };
                
                errorDiv.style.display = 'none';
                
            } catch (err) {
                console.error('Camera error:', err);
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Camera access denied or not available: ' + err.message;
            }
        }

        function closeCamera() {
            const modal = document.getElementById('cameraModal');
            const video = document.getElementById('cameraFeed');
            
            // Stop all camera tracks
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => {
                    track.stop();
                });
                cameraStream = null;
            }
            
            video.srcObject = null;
            modal.style.display = 'none';
        }

        function capturePhoto() {
            const video = document.getElementById('cameraFeed');
            const canvas = document.getElementById('photoCanvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw the video frame to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to blob
            canvas.toBlob(function(blob) {
                if (blob && currentUserId) {
                    // Create FormData for upload
                    const formData = new FormData();
                    formData.append('image', blob, 'camera-photo.jpg');
                    formData.append('user_id', currentUserId);
                    
                    // In real implementation, send to Laravel backend
                    // fetch('/seller/chatseller/send-image', {
                    //     method: 'POST',
                    //     body: formData,
                    //     headers: {
                    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    //     }
                    // }).then(response => response.json())
                    //   .then(data => {
                    //       // Handle response
                    //       console.log('Image sent successfully');
                    //   });
                    
                    // For demo - show in chat
                    const messagesArea = document.getElementById('messagesArea');
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'flex justify-end mb-4';
                    
                    const imageUrl = URL.createObjectURL(blob);
                    messageDiv.innerHTML = `
                        <div class="seller-gradient seller-corner text-white px-4 py-3 max-w-md">
                            <img src="${imageUrl}" alt="Captured photo" class="rounded-lg max-w-full h-auto mb-2">
                            <div class="text-sm">Photo sent</div>
                        </div>
                    `;
                    
                    if (messagesArea.querySelector('.text-center')) {
                        messagesArea.innerHTML = '<div class="space-y-4"></div>';
                    }
                    
                    messagesArea.querySelector('.space-y-4').appendChild(messageDiv);
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                    
                    alert('Photo captured and sent!');
                }
                
                closeCamera();
            }, 'image/jpeg', 0.8);
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const userItems = document.querySelectorAll('.user-item');
            const noResults = document.getElementById('noResults');
            let hasResults = false;

            userItems.forEach(item => {
                const userName = item.querySelector('.font-medium').textContent.toLowerCase();
                if (userName.includes(searchTerm)) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = hasResults ? 'none' : 'block';
        });

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
            console.error('getUserMedia is not supported in this browser');
        }
    </script>
</body>
</html>