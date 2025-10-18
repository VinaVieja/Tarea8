<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Averías</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h1 {
      font-weight: 600;
    }
    .custom-table {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .custom-table thead {
      background: linear-gradient(45deg, #007bff, #00c6ff);
      color: white;
      font-weight: bold;
    }
    .custom-table th, .custom-table td {
      vertical-align: middle;
      text-align: center;
      padding: 12px 10px;
    }
    .custom-table tbody tr:nth-child(odd) {
      background-color: #ffffff;
    }
    .custom-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .custom-table tbody tr:hover {
      background-color: #e2f0ff;
      transition: background-color 0.3s ease;
    }
    .btn-sm {
      margin: 2px;
    }
    select {
      border-radius: 6px;
      padding: 4px 8px;
    }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Averías</h1>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger">
        <ul><?php foreach (session()->getFlashdata('errors') as $error): ?><li><?= $error ?></li><?php endforeach; ?></ul>
      </div>
    <?php endif; ?>

    <div class="mb-4">
      <a class="btn btn-primary" href="<?= site_url('averias/create') ?>">Registrar nueva avería</a>
      <a class="btn btn-success" href="<?= site_url('averias/cumplidas') ?>">Ver cumplidas</a>
      <a class="btn btn-info text-white" href="<?= site_url('websocket') ?>">Ir al chat público</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered custom-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Problema</th>
            <th>Fecha</th>
            <th>Status</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($averias)): foreach ($averias as $a): ?>
          <tr>
            <td><?= esc($a['id']) ?></td>
            <td><?= esc($a['cliente']) ?></td>
            <td><?= esc($a['problema']) ?></td>
            <td><?= esc($a['fechahora']) ?></td>
            <td><?= esc($a['status']) ?></td>
            <td>
              <a class="btn btn-sm btn-info text-white" href="<?= site_url('averias/edit/' . $a['id']) ?>">Editar</a>
              <a class="btn btn-sm btn-danger" href="<?= site_url('averias/delete/' . $a['id']) ?>" onclick="return confirm('Eliminar?')">Eliminar</a>
              <a class="btn btn-sm btn-secondary text-white" href="<?= site_url('averias/chat/' . $a['id']) ?>">Chat</a>
              <form style="display:inline" method="post" action="<?= site_url('averias/update/' . $a['id']) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="cliente" value="<?= esc($a['cliente']) ?>">
                <input type="hidden" name="problema" value="<?= esc($a['problema']) ?>">
                <select name="status" onchange="this.form.submit()">
                  <option value="PENDIENTE" <?= $a['status'] == 'PENDIENTE' ? 'selected' : '' ?>>PENDIENTE</option>
                  <option value="EN_PROCESO" <?= $a['status'] == 'EN_PROCESO' ? 'selected' : '' ?>>EN PROCESO</option>
                  <option value="CUMPLIDA" <?= $a['status'] == 'CUMPLIDA' ? 'selected' : '' ?>>CUMPLIDA</option>
                </select>
              </form>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr><td colspan="6" class="text-center">No hay averías.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
