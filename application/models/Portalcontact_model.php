<?php
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */
/** Versão antiga, não se basear por ela */

defined('BASEPATH') OR exit('No direct script access allowed');

class Portalcontact_model extends CI_Model {
    
    var $table = "protal_contact";

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
            'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'telefone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'ramal' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'whatsapp' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'facebook' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'instagram' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'twitter' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'youtube' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'linkedin' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'behance' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ),
            'endereco' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ),
            'google_maps' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
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

    public function save($dados)
    {
        $dados =  (array) $dados;
        if($this->db->get($this->table)->num_rows() > 0){
            $this->db->update($this->table, $dados);
            return $this->db->affected_rows();
        } else {
            return $this->db->insert($this->table, $dados);
        }
    }

    public function getAll()
    {
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            for ($i = 0; $i < sizeof($result); $i++) {
                $result[$i]->password = '';
            }
            return $result;
        } else {
            return NULL;
        }
    }
}
