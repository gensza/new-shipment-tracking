<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VesselSchedulesModel;

class VesselSchedules extends BaseController
{
    protected $vesselModel;
    protected $db;

    public function __construct()
    {
        $this->vesselModel = new VesselSchedulesModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('vessel/vesselSchedulesView');
    }

    public function get_data_vessel()
    {
        $data_sent = [
            'page' => $this->request->getVar('page'),
            'limit' => $this->request->getVar('limit'),
            'origin' => $this->request->getVar('origin'),
            'destination' => $this->request->getVar('destination'),
            'month' => $this->request->getVar('month'),
            'routes' => $this->request->getVar('routes')
        ];

        $result = [
            'data' => $this->vesselModel->get_data_vessel($data_sent),
            'data_count_all' => $this->vesselModel->get_data_vessel_count_all()
        ];

        echo json_encode($result);
    }

    public function edit_vessel($id)
    {
        $data['id_vessel'] = $id;
        return view('vessel/editVesselView', $data);
    }

    public function get_data_vessel_by_id()
    {
        $id_vessel = $this->request->getVar('id_vessel');
        $data = $this->vesselModel->get_data_vessel_by_id($id_vessel);

        echo json_encode($data);
    }

    public function get_data_transshipment()
    {
        $noref = $this->request->getVar('noref');
        $data = $this->vesselModel->get_data_transshipment($noref);

        echo json_encode($data);
    }

    public function get_shipping_line()
    {
        $data = $this->vesselModel->get_shipping_line();

        echo json_encode($data);
    }

    public function get_port_line()
    {
        $data = $this->vesselModel->get_port_line();

        echo json_encode($data);
    }

    public function add_data_transshipment()
    {
        $data['noref_vessel_schedules'] = $this->request->getVar('noref');
        $data['port_name'] = $this->request->getVar('port_name');

        $result = $this->vesselModel->add_data_transshipment_edit($data);

        echo json_encode($result);
    }

    public function edit_data_vessel()
    {

        if (!empty($_FILES['fileupload']['tmp_name'])) {

            $uploadpath   = 'assets/document/logoShipping/';
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

        $id = $this->request->getVar('id');
        $data['shipping_line'] = $this->request->getVar('shipping_line');
        $data['etd'] = $this->request->getVar('date_etd');
        $data['eta'] = $this->request->getVar('date_eta');
        $data['origin'] = $this->request->getVar('origin');
        $data['destination'] = $this->request->getVar('destination');
        $data['transit_day'] = $this->request->getVar('transit_day');
        $data['ship_name'] = $this->request->getVar('ship_name');
        $data['ship_number'] = $this->request->getVar('ship_number');
        $data['trans_loading'] = $this->request->getVar('trans_loading');
        $data['status'] = 1;
        $data['user_update'] = session()->get('user_name');
        $data['update_at'] = date('Y-m-d h:i:s');

        $result_edit_shipment = $this->vesselModel->edit_data_vessel($data, $id);

        $result = [
            'result_edit_shipment' => $result_edit_shipment,
        ];

        echo json_encode($result);
    }

    public function add_data_vessel()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $noref = str_replace(" ", "", $this->request->getVar('shipping_line')) . '/' . date("d-m-Y") . '/' . $this->generate_string($permitted_chars, 10);

        if (!empty($_FILES['fileupload']['tmp_name'])) {

            $uploadpath   = 'assets/document/logoShipping/';
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
        } else {
            $data['logo'] = '';
        }

        if ($this->request->getVar('trans_loading') == 'Transshipment') {
            $list_transshipment = explode(",", $this->request->getVar('transshipment'));
            $rows_transshipment = [];
            for ($a = 0; $a < count($list_transshipment); $a++) {
                $data_con['noref_vessel_schedules'] = $noref;
                $data_con['port_name'] = $list_transshipment[$a];

                $rows_transshipment[] = $data_con;
            }

            $result_add_transshipment = $this->vesselModel->add_data_transshipment($rows_transshipment);
        }

        $data['noref'] = $noref;
        $data['shipping_line'] = $this->request->getVar('shipping_line');
        $data['etd'] = $this->request->getVar('date_etd');
        $data['eta'] = $this->request->getVar('date_eta');
        $data['origin'] = $this->request->getVar('origin');
        $data['destination'] = $this->request->getVar('destination');
        $data['transit_day'] = $this->request->getVar('transit_day');
        $data['ship_name'] = $this->request->getVar('ship_name');
        $data['ship_number'] = $this->request->getVar('ship_number');
        $data['trans_loading'] = $this->request->getVar('trans_loading');
        $data['status'] = 1;
        $data['user_update'] = session()->get('user_name');
        $data['update_at'] = date('Y-m-d h:i:s');

        $result_add_shipment = $this->vesselModel->add_data_vessel($data);

        $result = [
            'result_add_shipment' => $result_add_shipment,
            'result_add_transshipment' => $result_add_transshipment
        ];

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

    public function cek_before_delete()
    {
        $noref = $this->request->getVar('noref');
        $data = $this->vesselModel->cek_before_delete($noref);

        echo json_encode($data);
    }

    public function delete_vessel()
    {
        $noref = $this->request->getVar('noref');
        $data = $this->vesselModel->delete_vessel($noref);

        echo json_encode($data);
    }

    public function delete_transshipment()
    {
        $id = $this->request->getVar('id');
        $data = $this->vesselModel->delete_transshipment($id);

        echo json_encode($data);
    }

    public function search_filter()
    {
        $noref = $this->request->getVar('noref');
        $data = $this->vesselModel->search_filter($noref);

        echo json_encode($data);
    }
}
