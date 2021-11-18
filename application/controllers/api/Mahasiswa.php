<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        } else {
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }


        if ($mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mahasiswa->deleteMahasiswa($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'provide an id!'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'nrp' => $this->post('nrp'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->mahasiswa->createMahasiswa($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new mahasiswa has ben created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to created new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');

        $data = [
            'nama' => $this->put('nama'),
            'nrp' => $this->put('nrp'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->mahasiswa->updateMahasiswa($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data mahasiswa has ben updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
