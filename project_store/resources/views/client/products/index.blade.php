@extends('layouts.client')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tiêu đề -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                @if(request('search'))
                    Kết quả tìm kiếm: "{{ request('search') }}"
                @else
                    Danh sách sản phẩm
                @endif
            </h1>
            @if(request('search'))
                <p class="mt-2 text-gray-600">
                    Tìm thấy {{ $products->total() }} sản phẩm
                    <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline ml-2">
                        Xem tất cả sản phẩm
                    </a>
                </p>
            @endif
        </div>

        <!-- Danh sách sản phẩm -->
        @if($products->count())
        <div class="row">
            @foreach($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                             alt="{{ $product->name }}"
                             class="card-img-top" style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted small mb-1">{{ $product->category->name }}</span>
                        <h5 class="card-title mb-1" style="font-size: 1rem;">
                            <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                        </h5>
                        <p class="card-text mb-2" style="font-size: 0.95rem;">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">{{ number_format($product->price) }} VNĐ</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Phân trang -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @else
        <!-- Trạng thái rỗng -->
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy sản phẩm</h3>
            <p class="text-gray-500">
                @if(request('search'))
                    Không có sản phẩm nào phù hợp với từ khóa "{{ request('search') }}"
                @else
                    Hiện tại chưa có sản phẩm nào
                @endif
            </p>
            @if(request('search'))
            <div class="mt-4">
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                    Xem tất cả sản phẩm
                </a>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Chat Box AI OpenAI GPT -->
<div id="ai-chatbox" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999;">
    <div id="ai-chat-window" style="display: none; width: 350px; height: 420px; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.18); overflow: hidden; display: flex; flex-direction: column;">
        <div style="background: #1b1b18; color: #fff; padding: 12px 16px; font-weight: bold;">AI Chatbot <span style="float:right; cursor:pointer;" onclick="document.getElementById('ai-chat-window').style.display='none'">&times;</span></div>
        <div id="ai-chat-messages" style="flex: 1; padding: 16px; overflow-y: auto; background: #f9f9f9;"></div>
        <form id="ai-chat-form" style="display: flex; border-top: 1px solid #eee;">
            <input id="ai-chat-input" type="text" placeholder="Nhập tin nhắn..." style="flex:1; border:none; padding: 12px; outline:none;">
            <button type="submit" style="background: #1b1b18; color: #fff; border:none; padding: 0 20px; cursor:pointer;">Gửi</button>
        </form>
    </div>
    <button id="ai-chat-toggle" style="width: 56px; height: 56px; border-radius: 50%; background: #1b1b18; color: #fff; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.18); font-size: 28px; cursor: pointer;">💬</button>
</div>

<script>
    const chatToggle = document.getElementById('ai-chat-toggle');
    const chatWindow = document.getElementById('ai-chat-window');
    const chatForm = document.getElementById('ai-chat-form');
    const chatInput = document.getElementById('ai-chat-input');
    const chatMessages = document.getElementById('ai-chat-messages');

    chatToggle.onclick = function() {
        chatWindow.style.display = 'flex';
        chatInput.focus();
    };

    chatForm.onsubmit = async function(e) {
        e.preventDefault();
        const userMsg = chatInput.value.trim();
        if (!userMsg) return;
        appendMessage('Bạn', userMsg, true);
        chatInput.value = '';
        chatInput.disabled = true;
        // Gửi lên server
        try {
            const res = await fetch('/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: userMsg })
            });
            const data = await res.json();
            let aiText = "Không có phản hồi";
            if (data.candidates && data.candidates[0] && data.candidates[0].content && data.candidates[0].content.parts && data.candidates[0].content.parts[0].text) {
                aiText = data.candidates[0].content.parts[0].text;
            }
            appendMessage('AI', aiText, false);
        } catch (err) {
            appendMessage('AI', 'Lỗi kết nối server!', false);
        }
        chatInput.disabled = false;
        chatInput.focus();
    };

    function appendMessage(sender, text, isUser) {
        const msg = document.createElement('div');
        msg.style.margin = '8px 0';
        msg.style.display = 'flex';
        msg.style.justifyContent = isUser ? 'flex-end' : 'flex-start';
        msg.innerHTML = `<div style="max-width: 70%; padding: 10px 16px; border-radius: 16px; background: ${isUser ? '#1b1b18' : '#eee'}; color: ${isUser ? '#fff' : '#222'}; font-size: 15px;">${text}</div>`;
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Đảm bảo chat window luôn ẩn khi load lại trang
    window.onload = function() {
        chatWindow.style.display = 'none';
    };

    // Đóng chat khi bấm ra ngoài khung chat
    document.addEventListener('click', function(e) {
        if (chatWindow.style.display === 'flex' && !chatWindow.contains(e.target) && e.target !== chatToggle) {
            chatWindow.style.display = 'none';
        }
    });
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
