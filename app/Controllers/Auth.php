<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DataSetupModel;

class Auth extends BaseController
{
    public function index()
    {
        helper(['form']);
        $dataSetupModel = new DataSetupModel();
        $data_setup_profile = $dataSetupModel->get_data_setup_profile();
        $data['logo'] = $data_setup_profile[0]['logo'];
        $data['title'] = $data_setup_profile[0]['title'];

        return view('auth/loginView', $data);
    }

    public function register()
    {
        helper(['form']);
        $dataSetupModel = new DataSetupModel();
        $data_setup_profile = $dataSetupModel->get_data_setup_profile();
        $data['data_shipper'] = $dataSetupModel->get_data_setup_shipper();
        $data['logo'] = $data_setup_profile[0]['logo'];
        $data['title'] = $data_setup_profile[0]['title'];

        return view('auth/registerView', $data);
    }

    public function add_register()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $rules = [
            'name'          => 'required|min_length[3]|max_length[20]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.user_email]',
            'password'      => 'required|min_length[5]|max_length[200]',
            'confpassword'  => 'matches[password]',
            'level'         => 'required'
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'user_name'     => $this->request->getVar('name'),
                'user_email'    => $this->request->getVar('email'),
                'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'level'         => $this->request->getVar('level'),
                'id_shipper'    => $this->request->getVar('shipper'),
                'created_at'    => date('Y-m-d h:i:s')
            ];
            $model->save($data);

            if(session()->get('user_name')){
                return redirect()->to('/setup/users');
            }else{
                return redirect()->to('/auth');
            }
        } else {
            $data['validation'] = $this->validator;

            $dataSetupModel = new DataSetupModel();
            $data_setup_profile = $dataSetupModel->get_data_setup_profile();
            $data['data_shipper'] = $dataSetupModel->get_data_setup_shipper();
            $data['logo'] = $data_setup_profile[0]['logo'];
            $data['title'] = $data_setup_profile[0]['title'];
            return view('auth/registerView', $data);
        }
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $dataSetupModel = new DataSetupModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('user_email', $email)->first();
        $data_setup_profile = $dataSetupModel->get_data_setup_profile();
        if ($data) {
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'user_id'       => $data['id'],
                    'user_name'     => $data['user_name'],
                    'user_email'    => $data['user_email'],
                    'level'         => $data['level'],
                    'id_shipper'    => $data['id_shipper'],
                    'title'         => $data_setup_profile[0]['title'],
                    'logo'          => $data_setup_profile[0]['logo'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('msg', 'Email not Found');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}
