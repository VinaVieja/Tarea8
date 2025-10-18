<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Chat — CICHAT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #fff;
    }
    .chat-container {
      background: #ffffffdd;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 600px;
      display: flex;
      flex-direction: column;
      height: 80vh;
      overflow: hidden;
      padding: 24px 28px;
    }
    h3 {
      font-weight: 700;
      margin-bottom: 6px;
      color: #4b3f72;
      text-align: center;
      letter-spacing: 1.1px;
      user-select: none;
    }
    p.text-muted {
      font-style: italic;
      font-size: 0.9rem;
      text-align: center;
      margin-bottom: 24px;
      color: #555;
    }
    #chatBox {
      background: #fff;
      border-radius: 12px;
      padding: 16px 20px;
      flex-grow: 1;
      overflow-y: auto;
      box-shadow: inset 0 0 10px #ccc;
      font-size: 1rem;
      color: #333;
      user-select: text;
      margin-bottom: 20px;
    }
    .msg {
      margin-bottom: 14px;
      line-height: 1.4;
    }
    .msg .user {
      font-weight: 700;
      color: #5a3eeb;
      user-select: text;
    }
    .msg .time {
      font-size: 0.75rem;
      color: #999;
      margin-left: 8px;
      user-select: none;
      font-style: italic;
    }
    .text-muted.fst-italic.small {
      color: #666;
      margin-bottom: 12px;
      user-select: none;
    }
    .input-group {
      gap: 12px;
    }
    #userName, #messageInput {
      border-radius: 12px;
      border: 1.8px solid #ccc;
      padding: 14px 16px;
      font-size: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      flex-shrink: 0;
      user-select: text;
    }
    #userName {
      max-width: 130px;
    }
    #messageInput {
      flex-grow: 1;
    }
    #userName:focus, #messageInput:focus {
      border-color: #5a3eeb;
      box-shadow: 0 0 10px rgba(90, 62, 235, 0.4);
      outline: none;
    }
    #sendButton {
      background-color: #5a3eeb;
      border: none;
      border-radius: 12px;
      color: white;
      font-weight: 700;
      padding: 14px 26px;
      font-size: 1rem;
      cursor: pointer;
      user-select: none;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      flex-shrink: 0;
    }
    #sendButton:hover {
      background-color: #4629b9;
      box-shadow: 0 4px 14px rgba(70, 41, 185, 0.6);
    }
    .btn-secondary {
      background-color: #888;
      border: none;
      padding: 10px 18px;
      border-radius: 12px;
      font-weight: 600;
      color: white;
      text-align: center;
      user-select: none;
      transition: background-color 0.3s ease;
      margin-top: 20px;
      align-self: center;
      text-decoration: none;
      width: max-content;
    }
    .btn-secondary:hover {
      background-color: #555;
      text-decoration: none;
      color: white;
    }
    @media (max-width: 480px) {
      .chat-container {
        height: 90vh;
        padding: 18px 22px;
      }
      #userName {
        max-width: 100px;
        padding: 12px 14px;
        font-size: 0.9rem;
      }
      #messageInput {
        font-size: 0.95rem;
      }
      #sendButton {
        padding: 12px 20px;
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <h3>💬 Chat público</h3>
    <div id="chatBox" aria-live="polite" aria-label="Mensajes del chat"></div>

    <div class="input-group">
      <input id="userName" type="text" placeholder="Tu nombre (ej. Pedro)" aria-label="Nombre de usuario" />
      <input id="messageInput" type="text" placeholder="Escribe tu mensaje..." aria-label="Mensaje" />
      <button id="sendButton" type="button" aria-label="Enviar mensaje">Enviar</button>
    </div>

    <a class="btn btn-secondary" href="<?= site_url('averias') ?>">Ver averías</a>
  </div>

  <script>
    const WS_URL = 'ws://127.0.0.1:8080';
    let conn;
    const chatBox = document.getElementById('chatBox');
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    const usernameInput = document.getElementById('userName');

    function connect() {
      conn = new WebSocket(WS_URL);

      conn.onopen = () => {
        addSystemMessage("✅ Conectado al servidor.");
      };

      conn.onmessage = (e) => {
        const data = JSON.parse(e.data);
        if (data.type === 'system') {
          addSystemMessage(data.message);
        } else if (data.type === 'message') {
          addMessage(data.username, data.message, data.timestamp);
        }
      };

      conn.onclose = () => {
        addSystemMessage("⚠️ Conexión cerrada. Reintentando en 3s...");
        setTimeout(connect, 3000);
      };
    }

    function addSystemMessage(text) {
      const div = document.createElement('div');
      div.classList.add('text-muted', 'fst-italic', 'small');
      div.style.color = '#666';
      div.style.marginBottom = '12px';
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
      conn.send(JSON.stringify({ type: 'message', username, message }));
      messageInput.value = '';
      messageInput.focus();
    });

    messageInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') sendButton.click();
    });

    connect();
  </script>
</body>
</html>
