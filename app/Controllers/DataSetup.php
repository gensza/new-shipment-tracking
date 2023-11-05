<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataSetupModel;

class DataSetup extends BaseController
{
    protected $dataSetupModel;
    protected $db;

    public function __construct()
    {
        $this->dataSetupModel = new DataSetupModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('errors/html/error_404');
    }

    // start setup status
    public function status()
    {
        return view('setup/setupStatusView');
    }

    public function get_data_setup_status()
    {
        $result = $this->dataSetupModel->get_data_setup_status();

        echo json_encode($result);
    }

    public function add_data_setup_status()
    {
        $data['status'] = $this->request->getVar('status');

        $result = $this->dataSetupModel->add_data_setup_status($data);

        echo json_encode($result);
    }

    public function delete_data_setup_status()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_status($data);

        echo json_encode($result);
    }
    // end setup status

    // start setup shippingline
    public function shippingline()
    {
        return view('setup/setupShippingLineView');
    }

    public function get_data_setup_shippingline()
    {
        $result = $this->dataSetupModel->get_data_setup_shippingline();

        echo json_encode($result);
    }

    public function add_data_setup_shippingline()
    {
        $data['shippingline'] = $this->request->getVar('shippingline');

        $result = $this->dataSetupModel->add_data_setup_shippingline($data);

        echo json_encode($result);
    }

    public function delete_data_setup_shippingline()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_shippingline($data);

        echo json_encode($result);
    }
    // end setup shippingline

    // start setup shipper
    public function shipper()
    {
        return view('setup/setupShipperView');
    }

    public function get_data_setup_shipper()
    {
        $result = $this->dataSetupModel->get_data_setup_shipper();

        echo json_encode($result);
    }

    public function add_data_setup_shipper()
    {
        $data['shipper'] = $this->request->getVar('shipper');
        $data['admin_name'] = $this->request->getVar('admin_name');
        $data['admin_email'] = $this->request->getVar('admin_email');

        $result = $this->dataSetupModel->add_data_setup_shipper($data);

        echo json_encode($result);
    }

    public function delete_data_setup_shipper()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_shipper($data);

        echo json_encode($result);
    }
    // end setup shipper

    // start setup portline
    public function portline()
    {
        return view('setup/setupPortLineView');
    }

    public function get_data_setup_portline()
    {
        $result = $this->dataSetupModel->get_data_setup_portline();

        echo json_encode($result);
    }

    public function add_data_setup_portline()
    {
        $data['portline'] = $this->request->getVar('portline');
        $data['region'] = $this->request->getVar('region');

        $result = $this->dataSetupModel->add_data_setup_portline($data);

        echo json_encode($result);
    }

    public function delete_data_setup_portline()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_portline($data);

        echo json_encode($result);
    }
    // end setup portline

    // start setup incoterm
    public function incoterm()
    {
        return view('setup/setupIncotermView');
    }

    public function get_data_setup_incoterm()
    {
        $result = $this->dataSetupModel->get_data_setup_incoterm();

        echo json_encode($result);
    }

    public function add_data_setup_incoterm()
    {
        $data['incoterm'] = $this->request->getVar('incoterm');

        $result = $this->dataSetupModel->add_data_setup_incoterm($data);

        echo json_encode($result);
    }

    public function delete_data_setup_incoterm()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_incoterm($data);

        echo json_encode($result);
    }
    // end setup incoterm

    // start setup logo
    public function profile()
    {
        return view('setup/setupLogoView');
    }

    public function get_data_setup_profile()
    {
        $result = $this->dataSetupModel->get_data_setup_profile();

        echo json_encode($result);
    }

    public function add_data_setup_profile()
    {
        if (!empty($_FILES['fileupload']['tmp_name'])) {

            $uploadpath   = 'assets/document/logoProfile/';
            $file_count = $_FILES['fileupload']['name'];

            // $rows_file = [];
            for ($i = 0; $i < count($file_count); $i++) {
                $files = [
                    'name'     => $_FILES['fileupload']['name'][$i],
                    'tmp_name' => $_FILES['fileupload']['tmp_name'][$i],
                ];

                $ImageExt       = substr($files['name'], strrpos($files['name'], '.'));
                $ImageExt       = str_replace('.', '', $ImageExt); // Extension
                // $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $files['name']);
                $NewImageName   = str_replace(' ', '', $files['name']);

                move_uploaded_file($files["tmp_name"], $uploadpath . $NewImageName);

                $data['logo'] = $NewImageName;
            }
        }

        $data['title'] = $this->request->getVar('title');

        $result = $this->dataSetupModel->add_data_setup_profile($data);

        echo json_encode($result);
    }

    function generate_string($input, $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    // end setup logo

    // start setup users
    public function users()
    {
        return view('setup/setupUsersView');
    }

    public function get_data_setup_users()
    {
        $result = $this->dataSetupModel->get_data_setup_users();

        echo json_encode($result);
    }

    public function delete_data_setup_users()
    {
        $data['id'] = $this->request->getVar('id');

        $result = $this->dataSetupModel->delete_data_setup_users($data);

        echo json_encode($result);
    }
    // end setup users
}
