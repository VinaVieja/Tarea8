<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Chat de Avería #<?= esc($averia['id']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #chatBox { height: 50vh; overflow: auto; background: #fff; padding: 12px; border: 1px solid #ddd; border-radius: 8px; }
    .msg { margin-bottom: 10px; }
    .msg .user { font-weight: 700; color: #0d6efd; }
    .msg .time { font-size: 0.8em; color: #666; }
    body { background-color: #f8f9fa; }
  </style>
</head>
<body class="p-4">
<div class="container">
  <h3>💬 Chat para Avería #<?= esc($averia['id']) ?> - Cliente: <?= esc($averia['cliente']) ?></h3>
  <p class="text-muted">Problema: <?= esc($averia['problema']) ?> | Fecha: <?= esc($averia['fechahora']) ?></p>

  <div id="chatBox" class="mb-3"></div>

  <div class="input-group mb-3">
    <input id="userName" class="form-control" placeholder="Tu nombre (ej. Técnico)">
    <input id="messageInput" class="form-control" placeholder="Escribe tu mensaje...">
    <button id="sendButton" class="btn btn-primary">Enviar</button>
  </div>

  <a class="btn btn-secondary" href="<?= site_url('averias') ?>">Volver a averías</a>
</div>

<script>
  const WS_URL = 'ws://127.0.0.1:8080';
  let conn;
  const chatBox = document.getElementById('chatBox');
  const sendButton = document.getElementById('sendButton');
  const messageInput = document.getElementById('messageInput');
  const usernameInput = document.getElementById('userName');
  const averiaId = <?= esc($averia['id']) ?>;

  function connect() {
    conn = new WebSocket(WS_URL);

    conn.onopen = () => {
      addSystemMessage("✅ Conectado al servidor.");
      loadMessages();  // Carga mensajes previos al conectar
    };

    conn.onmessage = (e) => {
      const data = JSON.parse(e.data);
      if (data.type === 'system') {
        addSystemMessage(data.message);
      } else if (data.type === 'message' && data.averia_id == averiaId) {
        addMessage(data.username, data.message, data.timestamp);
      }
    };

    conn.onclose = () => {
      addSystemMessage("⚠️ Conexión cerrada. Reintentando en 3s...");
      setTimeout(connect, 3000);
    };
  }

  function loadMessages() {
    fetch('<?= site_url('averias/mensajes/' . $averia['id']) ?>')
      .then(response => response.json())
      .then(data => {
        data.forEach(msg => addMessage(msg.username, msg.message, msg.created_at));
      });
  }

  function addSystemMessage(text) {
    const div = document.createElement('div');
    div.classList.add('text-muted', 'fst-italic', 'small');
    div.textContent = text;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function addMessage(user, message, time) {
    const div = document.createElement('div');
    div.classList.add('msg');
    div.innerHTML = `<span class="user">${user}:</span> ${message} <span class="time">(${time})</span>`;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  sendButton.addEventListener('click', () => {
    const username = usernameInput.value.trim();
    const message = messageInput.value.trim();
    if (!username || !message) {
      alert('Ingresa tu nombre y mensaje.');
      return;
    }
    conn.send(JSON.stringify({ type: 'message', username, message, averia_id: averiaId }));
    messageInput.value = '';
  });

  messageInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendButton.click();
  });

  connect();
</script>
</body>
</html>