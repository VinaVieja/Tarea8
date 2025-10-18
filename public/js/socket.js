// public/js/socket.js
(function () {
  let ws;
  const chatBox = document.getElementById('chatBox');
  const sendButton = document.getElementById('sendButton');
  const messageInput = document.getElementById('messageInput');
  const userName = document.getElementById('userName');

  function connect() {
    ws = new WebSocket('ws://127.0.0.1:8080');

    ws.onopen = () => {
      console.log('Conectado al servidor WS');
      appendSystem('Conectado al servidor.');
    };

    ws.onmessage = (e) => {
      try {
        const d = JSON.parse(e.data);
        if (d.type === 'message') {
          appendMessage(d.username, d.message, d.timestamp);
        } else if (d.type === 'system') {
          appendSystem(d.message);
        }
      } catch (err) {
        console.error('WS parse error', err);
      }
    };

    ws.onclose = () => {
      appendSystem('Conexión cerrada. Reintentando en 3s...');
      setTimeout(connect, 3000);
    };

    ws.onerror = (err) => console.error('WS error', err);
  }

  function appendSystem(txt) {
    if (!chatBox) return;
    const el = document.createElement('div');
    el.className = 'text-muted mb-2';
    el.textContent = txt;
    chatBox.appendChild(el);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function appendMessage(user, msg, time) {
    if (!chatBox) return;
    const el = document.createElement('div');
    el.className = 'msg p-2 border rounded';
    el.innerHTML = `<div class="user">${escapeHtml(user)} <span class="time">(${time})</span></div>
                    <div class="text">${escapeHtml(msg)}</div>`;
    chatBox.appendChild(el);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function send() {
    const u = (userName && userName.value.trim()) ? userName.value.trim() : 'Anonimo';
    const m = (messageInput && messageInput.value.trim()) ? messageInput.value.trim() : '';
    if (!m) return;
    const payload = { username: u, message: m };
    if (ws && ws.readyState === WebSocket.OPEN) {
      ws.send(JSON.stringify(payload));
      messageInput.value = '';
    } else {
      alert('Socket desconectado. Intenta en unos segundos.');
    }
  }

  sendButton && sendButton.addEventListener('click', send);
  messageInput && messageInput.addEventListener('keypress', function(e){ if (e.key==='Enter') send(); });

  function escapeHtml(s){ return s.replace(/[&<>"']/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[ch])); }

  connect();
})();
