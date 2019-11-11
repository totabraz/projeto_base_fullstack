<?php

defined('BASEPATH') or exit('No direct script access allowed');


class User_model extends CI_Model
{
    var $table = 'users';
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
                'auto_increment' => TRUE
            ),
            'login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'full_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'permission_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'permission_value' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'blocked' => array(
                'type' => 'TINYINT',
                'constraint' => '1'
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        );
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->add_field($fields);
        if ($this->dbforge->create_table($this->table, TRUE)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function save($dados)
    {
        $dados =  (array) $dados;
        if (isset($dados['ID']) && $dados['ID'] > 0) {
            // User já existe. Devo editar
            $this->db->where('ID', $dados['ID']);
            unset($dados['ID']);
            $this->db->update($this->table, $dados);
            return $this->db->affected_rows();
        } else {
            // User não existe. Devo salvar

            $this->db->insert($this->table, $dados);
            return $this->db->insert_id();
        }
    }

    public function getAll($sort = 'ID', $limit = NULL, $offset = NULL, $order = 'asc')
    {
        $this->db->order_by($sort, $order);
        if ($limit)
            $this->db->limit($limit, $offset);
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

    public function countAllByPermissions($permissions = NULL)
    {
        return $this->countAll($permissions, NULL);
    }

    public function countAll($permissions = NULL, $full_name = NULL, $email = NULL, $phone = NULL)
    {
        if ($permissions) $this->db->where('permissions', $permissions);
        if ($full_name) $this->db->like('full_name', $full_name);
        if ($email) $this->db->where('email', $email);
        if ($phone) $this->db->where('phone', $phone);
        return $this->db->count_all($this->table);
    }

    public function excluirUser($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function getMyUserInfo()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        if (isset($this->session->userdata['login'])) $login = $this->session->userdata['login'];
        if (isset($login)) {
            $this->db->where('login', $login);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                return $row;
            } else {
                return NULL;
            }
        }
    }

    public function getUserByLoginOrEmail($login = NULL)
    {
        return $this->getUser($login, $login);
    }

    public function getUserByLogin($login = NULL)
    {
        return $this->getUser($login, NULL);
    }

    public function getUserByEmail($email = NULL)
    {
        return $this->getUser(NULL, $email);
    }

    public function getUserById($id = 0)
    {
        return $this->getUser(NULL, NULL, $id);
    }

    private function getUser($login = NULL, $email = NULL, $id = 0)
    {
        $return = NULL;
        if (isset($login)) {
            safeInput($login);
            $this->db->where('login', $login);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $return = $row;
                $find = TRUE;
            }
        }
        if (isset($email) && is_null($return)) {
            safeInput($email);
            $this->db->where('email', $email);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $return = $row;
            }
        }
        if ($id > 0 && is_null($return)) {
            $this->db->where('ID', $id);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $return = $row;
            }
        }

        return $return;
    }
}
