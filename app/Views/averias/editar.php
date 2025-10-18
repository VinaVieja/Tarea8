<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Editar Avería #<?= esc($averia['id']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f5f7fa;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #333;
      padding: 40px 15px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }
    .form-container {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 480px;
      width: 100%;
      padding: 30px 35px;
      border: 1px solid #e1e4e8;
    }
    h1 {
      font-weight: 600;
      font-size: 1.8rem;
      margin-bottom: 25px;
      text-align: center;
      color: #2c3e50;
      letter-spacing: 1.2px;
    }
    label {
      font-weight: 500;
      font-size: 0.9rem;
      margin-bottom: 8px;
      display: block;
      color: #4a4a4a;
    }
    .form-control, .form-select {
      border-radius: 6px;
      border: 1.8px solid #cbd2d9;
      padding: 12px 14px;
      font-size: 1rem;
      transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 6px rgba(59,130,246,0.4);
      outline: none;
    }
    .btn-primary {
      background-color: #3b82f6;
      border: none;
      width: 100%;
      padding: 14px 0;
      font-weight: 600;
      font-size: 1.1rem;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #2563eb;
    }
    .btn-secondary {
      margin-top: 15px;
      width: 100%;
      padding: 14px 0;
      font-weight: 600;
      font-size: 1.1rem;
      border-radius: 6px;
      border: 1.8px solid #94a3b8;
      color: #64748b;
      background: transparent;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .btn-secondary:hover {
      background-color: #e2e8f0;
      color: #334155;
      border-color: #334155;
      text-decoration: none;
    }
    .mb-4 {
      margin-bottom: 1.5rem !important;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Editar Avería #<?= esc($averia['id']) ?></h1>
    <form method="post" action="<?= site_url('averias/update/'.$averia['id']) ?>">
      <?= csrf_field() ?>

      <div class="mb-4">
        <label for="cliente">Cliente</label>
        <input id="cliente" name="cliente" type="text" class="form-control" value="<?= esc($averia['cliente']) ?>" required>
      </div>

      <div class="mb-4">
        <label for="problema">Problema</label>
        <input id="problema" name="problema" type="text" class="form-control" value="<?= esc($averia['problema']) ?>" required>
      </div>

      <div class="mb-4">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-select" required>
          <option value="PENDIENTE" <?= $averia['status']=='PENDIENTE'?'selected':'' ?>>PENDIENTE</option>
          <option value="EN_PROCESO" <?= $averia['status']=='EN_PROCESO'?'selected':'' ?>>EN PROCESO</option>
          <option value="CUMPLIDA" <?= $averia['status']=='CUMPLIDA'?'selected':'' ?>>CUMPLIDA</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="<?= site_url('averias') ?>" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</body>
</html>
