<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
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

    public function get_data_track_shipment($data)
    {
        $limit = $data['limit'];
        $limit_start = ($data['page'] - 1) * $limit;

        $limit = 'LIMIT ' . $limit_start . ',' . $limit;

        $query = "SELECT a.id, a.internal_number, a.bl_number, a.movement_type, a.status, a.port_loading, a.port_discharge, a.shipping_line, a.ci_pl_number, a.incoterm, a.update_at, b.logo, c.shipper_name AS shipper FROM tb_track_shipment a JOIN tb_vessel_schedules b ON a.noref_vessel_schedules = b.noref JOIN tb_shipper c ON a.id_shipper = c.id WHERE 1=1";

        if (!empty($data['filter']) || $data['filter'] != "") {
            $query = $query . " AND a.status = '" . $data['filter'] . "'";
        }

        if (!empty($data['search_filter']) || $data['search_filter'] != "") {
            $query = $query . " AND a.bl_number LIKE '%" . $data['search_filter'] . "%'";
        }

        if (session()->get('level') == "user") {
            $query = $query . " AND a.id_shipper = '" . session()->get('id_shipper') . "'";
        }

        $query = $this->db->query($query . " ORDER BY id DESC $limit");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_track_shipment_count_all()
    {
        if (session()->get('level') == "user") {
            $where = " WHERE id_shipper = " .session()->get('id_shipper');
            $where_status = " AND id_shipper = " .session()->get('id_shipper');
        }else{
            $where = "";
            $where_status = "";
        }

        $total_id = $this->db->query("SELECT count(id) as total_id FROM tb_track_shipment $where")->getRowArray();
        $total_delayed = $this->db->query("SELECT count(id) as total_delayed FROM tb_track_shipment WHERE `status` = 'At Origin' $where_status")->getRowArray();
        $total_in_transit = $this->db->query("SELECT count(id) as total_in_transit FROM tb_track_shipment WHERE `status` = 'In Transit' $where_status")->getRowArray();
        $total_in_destination = $this->db->query("SELECT count(id) as total_in_destination FROM tb_track_shipment WHERE `status` = 'Reached POD' $where_status")->getRowArray();

        $result = [
            'total_id' => $total_id,
            'total_delayed' => $total_delayed,
            'total_in_transit' => $total_in_transit,
            'total_in_destination' => $total_in_destination
        ];

        return $result;
    }

    public function get_data_shipper()
    {
        $query = $this->db->query("SELECT id, shipper_name FROM tb_shipper ORDER BY id ASC");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_shippingline()
    {
        $query = $this->db->query("SELECT shipping_name FROM tb_shipping_line ORDER BY id ASC");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_incoterm()
    {
        $query = $this->db->query("SELECT incoterm FROM tb_incoterm ORDER BY id ASC");
        $result = $query->getResultArray();

        return $result;
    }

    public function get_data_portline($data)
    {
        if ($data['region'] == 'international') {
            $where_is = "WHERE region NOT LIKE '%indonesia%'";
            $query = $this->db->query("SELECT port_name, region FROM tb_port_line $where_is ORDER BY id ASC");
            $result_1 = $query->getResultArray();

            $where_is_2 = "WHERE region LIKE '%indonesia%'";
            $query_2 = $this->db->query("SELECT port_name, region FROM tb_port_line $where_is_2 ORDER BY id ASC");
            $result_2 = $query_2->getResultArray();
        } else {
            $where_is = "WHERE region NOT LIKE '%indonesia%'";
            $query = $this->db->query("SELECT port_name, region FROM tb_port_line $where_is ORDER BY id ASC");
            $result_2 = $query->getResultArray();

            $where_is_2 = "WHERE region LIKE '%indonesia%'";
            $query_2 = $this->db->query("SELECT port_name, region FROM tb_port_line $where_is_2 ORDER BY id ASC");
            $result_1 = $query_2->getResultArray();
        }

        $result = [
            'pol' => $result_1,
            'pod' => $result_2
        ];

        return $result;
    }

    public function add_data_shipment($data)
    {
        $sql = "INSERT INTO tb_track_shipment (noref, noref_vessel_schedules, internal_number, 
                bl_number, movement_type, `status`, port_loading, port_discharge, 
                shipping_line, ship_number, ci_pl_number, incoterm, npe_peb_number, 
                shipment_owner, user_update, update_at, id_shipper) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->db->query($sql, array(
            $data['noref'], $data['noref_vessel_schedules'], $data['internal_number'], $data['bl_number'], $data['movement_type'],
            $data['status'], $data['port_loading'], $data['port_discharge'],
            $data['shipping_line'], $data['ship_number'], $data['ci_pl_number'], $data['incoterm'],
            $data['npe_peb_number'], $data['shipment_owner'],
            $data['user_update'], $data['update_at'], $data['shipper']
        ));

        return $result;
    }

    public function get_vessel_number($data)
    {
        $shipping_line = $data['shipping_line'];

        $query = $this->db->query("SELECT noref, ship_name, ship_number FROM tb_vessel_schedules WHERE shipping_line = '$shipping_line' AND `status` = 1 ORDER BY id DESC");
        $result = $query->getResultArray();

        return $result;
    }

    public function add_data_container($data)
    {
        $builder = $this->db->table('tb_container');
        return $builder->insertBatch($data);
    }

    public function delete_tracking($data)
    {
        $sql = "DELETE FROM tb_track_shipment WHERE id = ?";
        $result = $this->db->query($sql, array($data['id_tracking']));

        return $result;
    }

    public function do_upload($data)
    {
        $builder = $this->db->table('tb_document_shipment');
        return $builder->insertBatch($data);
    }
}
