<?php

namespace App\Controllers;

use App\Models\AveriaModel;
use App\Models\MensajeModel;
use CodeIgniter\Controller;

class Averias extends Controller
{
    protected $averiaModel;
    protected $mensajeModel;
    protected $helpers = ['form', 'url', 'text'];

    public function __construct()
    {
        $this->averiaModel = new AveriaModel();
        $this->mensajeModel = new MensajeModel();
    }

    public function index()
    {
        $data['averias'] = $this->averiaModel->where('status !=', 'CUMPLIDA')->orderBy('created_at', 'DESC')->findAll();
        return view('averias/listar', $data);
    }

    public function cumplidas()
    {
        $data['averias'] = $this->averiaModel->where('status', 'CUMPLIDA')->orderBy('updated_at', 'DESC')->findAll();
        return view('averias/cumplidas', $data);
    }

    public function create()
    {
        return view('averias/crear');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cliente' => 'required|min_length[3]',
            'problema' => 'required|min_length[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->averiaModel->insert([
            'cliente' => $this->request->getPost('cliente'),
            'problema' => $this->request->getPost('problema'),
            'fechahora' => $this->request->getPost('fechahora') ?? date('Y-m-d H:i:s'),
            'status' => $this->request->getPost('status') ?? 'PENDIENTE',
        ]);

        return redirect()->to('/averias')->with('success', 'Avería registrada.');
    }

    public function edit($id)
    {
        $data['averia'] = $this->averiaModel->find($id);
        return view('averias/editar', $data);
    }

    public function update($id)
    {
        $post = $this->request->getPost();
        $this->averiaModel->update($id, [
            'cliente' => $post['cliente'],
            'problema' => $post['problema'],
            'status' => $post['status'],
        ]);

        if ($post['status'] === 'CUMPLIDA') {
            return redirect()->to('/averias/cumplidas')->with('success', 'Avería marcada como cumplida.');
        }
        return redirect()->to('/averias')->with('success', 'Avería actualizada.');
    }

    public function delete($id)
    {
        $this->averiaModel->delete($id);
        return redirect()->to('/averias')->with('success', 'Avería eliminada.');
    }

    public function chat($id)
    {
        $averia = $this->averiaModel->find($id);
        if (!$averia) throw new \CodeIgniter\Exceptions\PageNotFoundException('Avería no encontrada');
        return view('averias/chat', ['averia' => $averia]);
    }

    public function mensajes($averia_id)
    {
        $mensajes = $this->mensajeModel->where('averia_id', $averia_id)->orderBy('created_at', 'ASC')->findAll();
        return $this->response->setJSON($mensajes);
    }
}