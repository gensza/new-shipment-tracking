<?php

namespace App\Models;

use CodeIgniter\Model;

class VesselSchedulesModel extends Model
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

    public function get_data_vessel($data)
    {
        $limit = $data['limit'];
        $limit_start = ($data['page'] - 1) * $limit;

        $limit = 'LIMIT ' . $limit_start . ',' . $limit;

        $query = 'SELECT a.id, a.logo, a.noref, a.shipping_line, a.etd, a.eta, a.origin, a.destination, a.transit_day, a.ship_name, a.ship_number, a.trans_loading, a.`status`, COUNT(b.noref_vessel_schedules) AS total_transit, b.port_name FROM tb_vessel_schedules a LEFT JOIN tb_transshipment b ON a.noref = b.noref_vessel_schedules WHERE 1=1';

        if (!empty($data['origin']) || $data['origin'] != "") {
            $query = $query . " AND a.origin = '" . $data['origin'] . "'";
        }

        if (!empty($data['destination']) || $data['destination'] != "") {
            $query = $query . " AND a.destination = '" . $data['destination'] . "'";
        }

        if (!empty($data['month']) || $data['month'] != "") {
            $query = $query . " AND a.etd LIKE '%" . date("Y") . "-" . $data['month'] . "%'";
        }

        if (!empty($data['routes']) || $data['routes'] != "") {
            $query = $query . " AND a.trans_loading = '" . $data['routes'] . "'";
        }

        $query = $this->db->query($query . " group BY a.noref ORDER BY id DESC $limit");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_vessel_count_all()
    {
        $query = $this->db->query("SELECT count(id) as total_id FROM tb_vessel_schedules");
        $result = $query->getRowArray();

        return $result;
    }

    public function get_data_vessel_by_id($id_vessel)
    {
        $query = $this->db->query("SELECT id, logo, noref, shipping_line, etd, eta, origin, destination, transit_day, ship_name, ship_number, trans_loading, `status` FROM tb_vessel_schedules WHERE id = '$id_vessel'");
        $result = $query->getRowArray();

        return $result;
    }

    public function get_data_transshipment($noref)
    {
        $query = $this->db->query("SELECT id, port_name FROM tb_transshipment WHERE noref_vessel_schedules = '$noref'");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_shipping_line()
    {
        $query = $this->db->query("SELECT id, shipping_name FROM tb_shipping_line ORDER BY id DESC");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_port_line()
    {
        $query = $this->db->query("SELECT id, port_name FROM tb_port_line ORDER BY id DESC");
        $result = $query->getResultArray();

        return $result;
    }

    public function add_data_vessel($data)
    {
        $builder = $this->db->table('tb_vessel_schedules');
        $result   = $builder->insert($data);

        return $result;
    }

    public function add_data_transshipment($data)
    {
        $builder = $this->db->table('tb_transshipment');
        return $builder->insertBatch($data);
    }

    public function cek_before_delete($noref)
    {
        $query = $this->db->query("SELECT id FROM tb_track_shipment WHERE noref_vessel_schedules = '$noref'");
        $result = $query->getNumRows();

        return $result;
    }

    public function delete_vessel($noref)
    {
        $sql = "DELETE FROM tb_vessel_schedules WHERE noref = ?";
        $result = $this->db->query($sql, array($noref));

        return $result;
    }

    public function delete_transshipment($id)
    {
        $sql = "DELETE FROM tb_transshipment WHERE id = ?";
        $result = $this->db->query($sql, array($id));

        return $result;
    }

    public function add_data_transshipment_edit($data)
    {
        $builder = $this->db->table('tb_transshipment');
        $result   = $builder->insert($data);

        return $result;
    }

    public function edit_data_vessel($data, $id)
    {
        $builder = $this->db->table('tb_vessel_schedules');
        $builder->where('id', $id);
        $result = $builder->update($data);

        return $result;
    }
}
