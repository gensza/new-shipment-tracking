<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TrackingModel;
use App\Models\HomeModel;

class Tracking extends BaseController
{
    protected $trackingModel;
    protected $homeModel;
    protected $db;

    public function __construct()
    {
        $this->trackingModel = new TrackingModel();
        $this->homeModel = new HomeModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        //
    }

    public function container($id)
    {
        $data['id'] = $id;
        return view('tracking/trackingContainerView', $data);
    }

    public function get_data_track_shipment()
    {
        $id = $this->request->getVar('id');
        $data = $this->trackingModel->get_data_track_shipment($id);

        echo json_encode($data);
    }

    public function get_data_port_name()
    {
        $noref_vessel_schedules = $this->request->getVar('noref_vessel_schedules');
        $data = $this->trackingModel->get_data_port_name($noref_vessel_schedules);

        echo json_encode($data);
    }

    public function get_data_dropdown()
    {
        $data['activity'] = $this->trackingModel->get_data_activity();

        echo json_encode($data);
    }

    public function add_data_tracking_event()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $noref = str_replace(" ", "", $this->request->getVar('ship_number')) . '/' . date("d-m-Y") . '/' . $this->generate_string($permitted_chars, 10);

        $data['noref'] = $noref;
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');
        $data['bl_number'] = $this->request->getVar('bl_number');
        $data['activity'] = $this->request->getVar('activity');
        $data['port'] = $this->request->getVar('port_type');
        $data['port_name'] = $this->request->getVar('port_name');
        $data['date'] = $this->request->getVar('date');
        $data['vehicle'] = $this->request->getVar('vehicle');
        $data['voyage'] = $this->request->getVar('voyage');
        $data['voyage_number'] = $this->request->getVar('voyage_number');
        $data['user_update'] = session()->get('user_name');
        $data['update_at'] = date('Y-m-d h:i:s');

        $result = $this->trackingModel->add_data_tracking_event($data);

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

    public function get_side_tracking()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');
        $data['port_name'] = $this->request->getVar('port_name');

        $data = $this->trackingModel->get_side_tracking($data);

        echo json_encode($data);
    }

    // public function get_data_tracking_events()
    // {
    //     $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');

    //     $data = $this->trackingModel->get_data_tracking_events($data);

    //     echo json_encode($data);
    // }

    public function get_status_direct()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');

        $data = $this->trackingModel->get_status_direct($data);

        echo json_encode($data);
    }

    public function change_status_track()
    {
        if ($this->request->getVar('type_status') == 'start') {
            $data['status'] = 'In Transit';
        } else if ($this->request->getVar('type_status') == 'end') {
            $data['status'] = 'Reached POD';
        }

        $key = $this->request->getVar('noref_track_shipment');

        $data = $this->trackingModel->change_status_track($data, $key);

        echo json_encode($data);
    }

    public function get_data_containers()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');

        $data = $this->trackingModel->get_data_containers($data);

        echo json_encode($data);
    }

    public function table_edit_activity()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');

        $data = $this->trackingModel->table_edit_activity($data);

        echo json_encode($data);
    }

    public function delete_activity_event()
    {
        $data['id_tracking_event'] = $this->request->getVar('id_tracking_event');

        $result = $this->trackingModel->delete_activity_event($data);

        echo json_encode($result);
    }

    public function add_data_container()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');
        $data['container_number'] = $this->request->getVar('container_number');
        $data['bl_number'] = $this->request->getVar('bl_number');

        $result = $this->trackingModel->add_data_container($data);

        echo json_encode($result);
    }

    public function delete_container()
    {
        $data['id_container'] = $this->request->getVar('id_container');

        $result = $this->trackingModel->delete_container($data);

        echo json_encode($result);
    }

    public function table_document()
    {
        $data['noref_track_shipment'] = $this->request->getVar('noref_track_shipment');

        $data = $this->trackingModel->table_document($data);

        echo json_encode($data);
    }

    public function delete_file_document()
    {
        $data['id_document'] = $this->request->getVar('id_document');

        $result = $this->trackingModel->delete_file_document($data);

        echo json_encode($result);
    }

    public function add_data_document()
    {
        $noref = $this->request->getVar('noref_track_shipment');

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

            $result = $this->homeModel->do_upload($rows_file);
        } else {
            $result = '';
        }


        echo json_encode($result);
    }
}
