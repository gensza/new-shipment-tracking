<?php

namespace App\Models;

use CodeIgniter\Model;

class TrackingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = '';
    protected $primaryKey       = '';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = [];

    public function get_data_activity()
    {
        $query = $this->db->query("SELECT activity_name FROM tb_activity ORDER BY id ASC");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_track_shipment($id)
    {
        $query = $this->db->query("SELECT a.noref, a.noref_vessel_schedules, a.internal_number, a.bl_number, a.movement_type, a.status, a.ship_number, a.port_loading, a.port_discharge, a.shipping_line, b.id as id_vessel_schedules, b.trans_loading, a.npe_peb_number, a.ci_pl_number, a.incoterm, b.logo FROM tb_track_shipment a JOIN tb_vessel_schedules b ON a.noref_vessel_schedules = b.noref WHERE a.id = $id");
        $result = $query->getRowArray();

        return $result;
    }

    public function get_data_port_name($noref_vessel_schedules)
    {
        $query = $this->db->query("SELECT port_name FROM tb_transshipment WHERE noref_vessel_schedules = '$noref_vessel_schedules' ORDER BY id DESC");
        $result = $query->getResultArray();

        return $result;
    }

    public function add_data_tracking_event($data)
    {
        $builder = $this->db->table('tb_tracking_events');
        $result   = $builder->insert($data);

        return $result;
    }

    public function get_side_tracking($data)
    {
        $noref = $data['noref_track_shipment'];
        $port_name = $data['port_name'];

        $query = $this->db->query("SELECT activity, port, port_name, `date` FROM tb_tracking_events WHERE noref_track_shipment = '$noref' AND port_name = '$port_name'");
        $result = $query->getResultArray();

        return $result;
    }

    // public function get_data_tracking_events($data)
    // {
    //     $noref = $data['noref_track_shipment'];

    //     $query = $this->db->query("SELECT port, port_name FROM tb_tracking_events WHERE noref_track_shipment = '$noref' ORDER BY id DESC LIMIT 1");
    //     $result = $query->getRowArray();

    //     return $result;
    // }

    public function get_status_direct($data)
    {
        $noref = $data['noref_track_shipment'];

        $query = $this->db->query("SELECT port FROM tb_tracking_events WHERE noref_track_shipment = '$noref' AND port = 'Direct' ORDER BY id DESC LIMIT 1");
        $result = $query->getRowArray();

        return $result;
    }

    public function change_status_track($data, $key)
    {
        $builder = $this->db->table('tb_track_shipment');
        $builder->where('noref', $key);
        $result   = $builder->update($data);

        return $result;
    }

    public function get_data_containers($data)
    {
        $noref = $data['noref_track_shipment'];

        $query = $this->db->query("SELECT id, container_number, bl_number FROM tb_container WHERE noref_track_shipment = '$noref'");
        $result = $query->getResultArray();

        return $result;
    }

    public function table_edit_activity($data)
    {
        $noref = $data['noref_track_shipment'];

        $query = $this->db->query("SELECT id, activity FROM tb_tracking_events WHERE noref_track_shipment = '$noref'");
        $result = $query->getResultArray();

        return $result;
    }

    public function delete_activity_event($data)
    {
        $sql = "DELETE FROM tb_tracking_events WHERE id = ?";
        $result = $this->db->query($sql, array($data['id_tracking_event']));

        return $result;
    }

    public function add_data_container($data)
    {
        $builder = $this->db->table('tb_container');
        $result   = $builder->insert($data);

        return $result;
    }

    public function delete_container($data)
    {
        $sql = "DELETE FROM tb_container WHERE id = ?";
        $result = $this->db->query($sql, array($data['id_container']));

        return $result;
    }

    public function table_document($data)
    {
        $noref = $data['noref_track_shipment'];

        $query = $this->db->query("SELECT id, `file_name` FROM tb_document_shipment WHERE noref_track_shipment = '$noref'");
        $result = $query->getResultArray();

        return $result;
    }

    public function delete_file_document($data)
    {
        $sql = "DELETE FROM tb_document_shipment WHERE id = ?";
        $result = $this->db->query($sql, array($data['id_document']));

        return $result;
    }
}
