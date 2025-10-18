<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Crear Avería</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.2);
      max-width: 450px;
      width: 100%;
      padding: 30px;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    h1 {
      font-weight: 700;
      color: #4b2b7f;
      margin-bottom: 30px;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }
    label {
      font-weight: 600;
      color: #555;
    }
    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      box-shadow: none !important;
      border: 2px solid #ddd;
      transition: border-color 0.3s ease;
    }
    .form-control:focus {
      border-color: #764ba2;
      box-shadow: 0 0 8px rgba(118,75,162,0.5);
      outline: none;
    }
    .btn-success {
      background: #764ba2;
      border: none;
      padding: 12px 25px;
      font-weight: 600;
      border-radius: 10px;
      transition: background 0.3s ease;
      width: 100%;
    }
    .btn-success:hover {
      background: #5a3670;
    }
    .btn-secondary {
      margin-top: 15px;
      width: 100%;
      border-radius: 10px;
      font-weight: 600;
    }
    .input-group-text {
      background: #764ba2;
      border: 2px solid #764ba2;
      color: white;
      border-radius: 10px 0 0 10px;
    }
    @media (max-width: 500px) {
      .card {
        padding: 20px;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Registrar Avería</h1>
    <form method="post" action="<?= site_url('averias/store') ?>">
      <?= csrf_field() ?>
      <div class="mb-4">
        <label for="cliente">Cliente</label>
        <div class="input-group">
          <span class="input-group-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
              <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg>
          </span>
          <input id="cliente" name="cliente" type="text" class="form-control" placeholder="Nombre del cliente" required>
        </div>
      </div>
      <div class="mb-4">
        <label for="problema">Problema</label>
        <div class="input-group">
          <span class="input-group-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.706c.89 0 1.439-.99.982-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>
          </span>
          <input id="problema" name="problema" type="text" class="form-control" placeholder="Descripción del problema" required>
        </div>
      </div>
      <button type="submit" class="btn btn-success">Guardar</button>
      <a href="<?= site_url('averias') ?>" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</body>
</html>
