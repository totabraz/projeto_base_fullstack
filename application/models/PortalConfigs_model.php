<?php
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */

defined('BASEPATH') OR exit('No direct script access allowed');

class PortalConfigs_model extends CI_Model {
    
    var $table = "portal_configs";

    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
        $this->checkTableExist();
    }

    private function checkTableExist()
    {
        $fields = array(
            'ID' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ),
            'option_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'option_value' => array(
                'type' => 'TEXT',
            ),
        );
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->add_field($fields);
        if ($this->dbforge->create_table($this->table, TRUE)) {
            return true;
        } else {
            return false;
        }
    }


    public function get_all_option()
    {

        return $this->db->get($this->table)->row();
    }


    public function get_option($option_name, $default_value = NULL)
    {
        $this->db->where('option_name', $option_name);
        $query = $this->db->get($this->table, 1);
        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row->option_value;
        } else {
            return $default_value;
        }
    }
    

    public function update_option($option_name, $option_value)
    {
        $this->db->where('option_name', $option_name);
        $query = $this->db->get($this->table, 1);
        if ($query->num_rows() == 1) {
            // opção já existente, devo atualizar
            $this->db->set('option_value', $option_value);
            $this->db->where('option_name', $option_name);
            $this->db->update($this->table);
            return $this->db->affected_rows();
        } else {
            // opção não existente, devo inserir
            $dados = array(
                'option_name' => $option_name,
                'option_value' => $option_value
            );
            $this->db->insert($this->table, $dados);
            return $this->db->insert_id();
        }
    }
}