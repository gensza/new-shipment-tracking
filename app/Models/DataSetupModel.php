<?php

namespace App\Models;

use CodeIgniter\Model;

class DataSetupModel extends Model
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

    // start setup status
    public function add_data_setup_status($data)
    {
        $sql = "INSERT INTO tb_status (status_name) VALUES (?)";
        $result = $this->db->query($sql, array($data['status']));

        return $result;
    }

    public function get_data_setup_status()
    {
        $sql = "SELECT id, status_name FROM tb_status ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_status($data)
    {
        $sql = "DELETE FROM tb_status WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup status

    // start setup shippingline
    public function add_data_setup_shippingline($data)
    {
        $sql = "INSERT INTO tb_shipping_line (shipping_name) VALUES (?)";
        $result = $this->db->query($sql, array($data['shippingline']));

        return $result;
    }

    public function get_data_setup_shippingline()
    {
        $sql = "SELECT id, shipping_name FROM tb_shipping_line ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_shippingline($data)
    {
        $sql = "DELETE FROM tb_shipping_line WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup shippingline

    // start setup shipper
    public function add_data_setup_shipper($data)
    {
        $sql = "INSERT INTO tb_shipper (shipper_name, admin_name, admin_email) VALUES (?,?,?)";
        $result = $this->db->query($sql, array($data['shipper'], $data['admin_name'], $data['admin_email']));

        return $result;
    }

    public function get_data_setup_shipper()
    {
        $sql = "SELECT id, shipper_name, admin_name, admin_email FROM tb_shipper ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_shipper($data)
    {
        $sql = "DELETE FROM tb_shipper WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup shipper

    // start setup portline
    public function add_data_setup_portline($data)
    {
        $sql = "INSERT INTO tb_port_line (port_name, region) VALUES (?,?)";
        $result = $this->db->query($sql, array($data['portline'], $data['region']));

        return $result;
    }

    public function get_data_setup_portline()
    {
        $sql = "SELECT id, port_name, region FROM tb_port_line ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_portline($data)
    {
        $sql = "DELETE FROM tb_port_line WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup portline

    // start setup incoterm
    public function add_data_setup_incoterm($data)
    {
        $sql = "INSERT INTO tb_incoterm (incoterm) VALUES (?)";
        $result = $this->db->query($sql, array($data['incoterm']));

        return $result;
    }

    public function get_data_setup_incoterm()
    {
        $sql = "SELECT id, incoterm FROM tb_incoterm ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_incoterm($data)
    {
        $sql = "DELETE FROM tb_incoterm WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup incoterm

    // start setup profile
    public function add_data_setup_profile($data)
    {
        $sql = "INSERT INTO tb_profile_company (logo, title) VALUES (?,?)";
        $result = $this->db->query($sql, array($data['logo'], $data['title']));

        return $result;
    }

    public function get_data_setup_profile()
    {
        $sql = "SELECT id, logo, title FROM tb_profile_company ORDER BY id DESC LIMIT 0,1";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }
    // end setup profile

    // start setup users
    public function get_data_setup_users()
    {
        $sql = "SELECT a.id, a.user_name, a.user_email, a.level, b.shipper_name as shipper FROM users a LEFT JOIN tb_shipper b ON a.id_shipper = b.id ORDER BY id ASC";
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }

    public function delete_data_setup_users($data)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $result = $this->db->query($sql, array($data['id']));

        return $result;
    }
    // end setup users

}
