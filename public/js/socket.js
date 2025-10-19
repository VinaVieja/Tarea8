(function () {
  let ws;
  let reconnectInterval = 2000;
  const chatBox = document.getElementById('chatBox');
  const sendButton = document.getElementById('sendButton');
  const messageInput = document.getElementById('messageInput');
  const userName = document.getElementById('userName');

  function getWsUrl() {
    const proto = (location.protocol === 'https:') ? 'wss://' : 'ws://';
    const host = location.hostname || '127.0.0.1';
    const port = '8080'; // puerto
    return proto + host + ':' + port;
  }

  function appendSystem(msg){
    if(!chatBox) return;
    const el = document.createElement('div');
    el.className = 'system';
    el.textContent = msg;
    chatBox.appendChild(el);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function appendMessage(user, text, time) {
    if(!chatBox) return;
    const el = document.createElement('div');
    el.className = 'message';
    el.innerHTML = '<strong>' + escapeHtml(user) + ':</strong> ' + escapeHtml(text) + 
                   (time ? ' <small>(' + escapeHtml(time) + ')</small>' : '');
    chatBox.appendChild(el);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function connect() {
    const url = getWsUrl();
    console.log('Conectando a', url);
    ws = new WebSocket(url);

    ws.onopen = () => {
      console.log('Conectado al servidor WS');
      appendSystem('Conectado al servidor.');
      reconnectInterval = 2000;
    };

    ws.onmessage = (evt) => {
      try {
        const data = JSON.parse(evt.data);
        if (data.system) {
          appendSystem(data.system);
          return;
        }
        appendMessage(data.user || 'Anon', data.msg || '', data.time || '');
      } catch (e) {
        console.error('Error parseando mensaje', e, evt.data);
      }
    };

    ws.onclose = () => {
      console.warn('Socket cerrado. Reintentando en', reconnectInterval, 'ms');
      appendSystem('Desconectado. Reintentando conexión...');
      setTimeout(connect, reconnectInterval);
      reconnectInterval = Math.min(30000, reconnectInterval * 1.5);
    };

    ws.onerror = (err) => {
      console.error('Socket error', err);
      try { ws.close(); } catch(e) {}
    };
  }

  function send() {
    const text = messageInput && messageInput.value;
    const user = userName && userName.value;
    if (!text) return;
    const payload = { user: user || 'Anon', msg: text };
    if (ws && ws.readyState === WebSocket.OPEN) {
      ws.send(JSON.stringify(payload));
      messageInput.value = '';
    } else {
      alert('Socket desconectado. Intenta en unos segundos.');
    }
  }

  sendButton && sendButton.addEventListener('click', send);
  messageInput && messageInput.addEventListener('keypress', function(e){ if (e.key==='Enter') send(); });

  function escapeHtml(s){ return String(s).replace(/[&<>"']/g, function(ch){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[ch]; }); }

  connect();
})();
