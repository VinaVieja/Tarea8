<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Averías cumplidas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px 15px;
      color: #333;
    }
    .wrapper {
      background: #fff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      width: 100%;
    }
    h1 {
      text-align: center;
      font-weight: 700;
      color: #334155;
      margin-bottom: 30px;
      letter-spacing: 2px;
      font-size: 2.2rem;
      text-transform: uppercase;
    }
    .btn-secondary {
      display: block;
      margin: 0 auto 35px auto;
      background: #334155;
      border: none;
      color: #fff;
      font-weight: 600;
      padding: 12px 35px;
      font-size: 1.1rem;
      border-radius: 8px;
      transition: background-color 0.3s ease;
      box-shadow: 0 6px 15px rgba(51, 65, 85, 0.3);
      text-decoration: none;
      text-align: center;
      width: max-content;
    }
    .btn-secondary:hover {
      background: #1e293b;
      box-shadow: 0 8px 20px rgba(30, 41, 59, 0.5);
      text-decoration: none;
      color: #fff;
    }
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 12px;
      font-size: 1rem;
      color: #475569;
    }
    thead tr {
      background-color: #334155;
      color: #e0e7ff;
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 1px;
      border-radius: 10px;
    }
    thead th {
      padding: 15px 20px;
      text-align: left;
    }
    tbody tr {
      background: #f1f5f9;
      border-radius: 10px;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 8px rgba(51, 65, 85, 0.08);
    }
    tbody tr:hover {
      background: #e0e7ff;
      box-shadow: 0 4px 15px rgba(51, 65, 85, 0.15);
    }
    tbody td {
      padding: 18px 20px;
      vertical-align: middle;
      border: none !important;
      border-radius: 10px;
    }
    tbody tr td:first-child {
      font-weight: 700;
      color: #1e293b;
    }
    tbody tr td:last-child {
      font-style: italic;
      color: #64748b;
    }
    tbody tr td[colspan="4"] {
      text-align: center;
      font-style: normal;
      font-weight: 600;
      padding: 25px 0;
      color: #94a3b8;
    }
    @media (max-width: 640px) {
      .wrapper {
        padding: 25px 20px;
      }
      thead th, tbody td {
        padding: 12px 10px;
      }
      h1 {
        font-size: 1.6rem;
      }
      .btn-secondary {
        font-size: 1rem;
        padding: 10px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h1>Averías cumplidas</h1>
    <a href="<?= site_url('averias') ?>" class="btn btn-secondary">Volver</a>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Problema</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($averias)): foreach($averias as $a): ?>
        <tr>
          <td><?= esc($a['id']) ?></td>
          <td><?= esc($a['cliente']) ?></td>
          <td><?= esc($a['problema']) ?></td>
          <td><?= esc($a['fechahora']) ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4">No hay cumplidas.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
