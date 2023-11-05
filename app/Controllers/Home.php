<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HomeModel;

class Home extends BaseController
{
    protected $homeModel;
    protected $db;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
        $this->db = \Config\Database::connect();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        return view('home/homeView');
    }

    public function get_data_track_shipment()
    {
        $data_sent = [
            'page' => $this->request->getVar('page'),
            'limit' => $this->request->getVar('limit'),
            'filter' => $this->request->getVar('filter'),
            'search_filter' => $this->request->getVar('search_filter')
        ];

        $result = [
            'data' => $this->homeModel->get_data_track_shipment($data_sent),
            'data_count_all' => $this->homeModel->get_data_track_shipment_count_all(),
        ];

        echo json_encode($result);
    }

    public function get_data_dropdown()
    {
        $data['shipper'] = $this->homeModel->get_data_shipper();
        $data['shippingline'] = $this->homeModel->get_data_shippingline();
        $data['incoterm'] = $this->homeModel->get_data_incoterm();

        echo json_encode($data);
    }

    public function get_data_portline()
    {
        $data['region'] = $this->request->getVar('region');

        $result = $this->homeModel->get_data_portline($data);

        echo json_encode($result);
    }

    public function get_vessel_number()
    {
        $data['shipping_line'] = $this->request->getVar('shipping_line');

        $result = $this->homeModel->get_vessel_number($data);

        echo json_encode($result);
    }

    public function add_data_shipment()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $noref = $this->request->getVar('movement_type') . '/' . date("d-m-Y") . '/' . $this->generate_string($permitted_chars, 10);

        if (!empty($_FILES['fileupload']['tmp_name'])) {

            $uploadpath   = 'assets/document/trackingShipment/';
            $file_count = $_FILES['fileupload']['name'];

            $rows_file = [];
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

                $data_file['noref_track_shipment'] = $noref;
                $data_file['folder_name'] = 'trackingShipment/';
                $data_file['file_name'] = $NewImageName;

                $rows_file[] = $data_file;
            }

            $result_do_upload = $this->homeModel->do_upload($rows_file);
        } else {
            $result_do_upload = '';
        }

        $ship_noref = explode("_", $this->request->getVar('ship_number'));

        $data['noref'] = $noref;
        $data['noref_vessel_schedules'] = $ship_noref[1];
        $data['internal_number'] = $this->request->getVar('internal_number');
        $data['bl_number'] = $this->request->getVar('bl_number');
        $data['movement_type'] = $this->request->getVar('movement_type');
        $data['status'] = 'At Origin';
        $data['shipper'] = $this->request->getVar('shipper');
        $data['shipment_owner'] = $this->request->getVar('shipment_owner');
        $data['shipping_line'] = $this->request->getVar('shipping_line');
        $data['ship_number'] = $ship_noref[0];
        $data['ci_pl_number'] = $this->request->getVar('ci_pl_number');
        $data['npe_peb_number'] = $this->request->getVar('npe_peb_number');
        $data['incoterm'] = $this->request->getVar('incoterm');
        $data['port_loading'] = $this->request->getVar('pol');
        $data['port_discharge'] = $this->request->getVar('pod');
        $data['user_update'] = session()->get('user_name');
        $data['update_at'] = date('Y-m-d H:i:s');

        $result_add_shipment = $this->homeModel->add_data_shipment($data);

        $list_container = explode(",", $this->request->getVar('container_number'));
        $rows_container = [];
        for ($a = 0; $a < count($list_container); $a++) {
            $data_con['container_number'] = $list_container[$a];
            $data_con['noref_track_shipment'] = $noref;
            $data_con['bl_number'] = $this->request->getVar('bl_number');

            $rows_container[] = $data_con;
        }

        $result_add_container = $this->homeModel->add_data_container($rows_container);

        $result = [
            'result_add_shipment' => $result_add_shipment,
            'result_add_container' => $result_add_container,
            'result_do_upload' => $result_do_upload,
            'cek_num' => $this->request->getVar('ship_number'),
            'cek' => $ship_noref[1]
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

    public function delete_tracking()
    {
        $data['id_tracking'] = $this->request->getVar('id_tracking');

        $result = $this->homeModel->delete_tracking($data);

        echo json_encode($result);
    }
}
