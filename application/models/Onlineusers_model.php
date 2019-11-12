<?php
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */

defined('BASEPATH') or exit('No direct script access allowed');

class Onlineusers_model extends CI_Model
{
    var $table = 'online_users';

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
            'tempo' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            ),
            'ip' => array(
                'type' => 'VARCHAR',
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
            // User não existe. Devo editar
            $this->db->insert($this->table, $dados);
            return $this->db->insert_id();
        }
    }

    private function getIp(){
        return $_SERVER['REMOTE_ADDR'];
    }

    private function getTime(){
        date_default_timezone_set('America/Sao_Paulo');
        return time() + (60 * 10);
    }

    private function verifica_ip_online($con){
        $ip = getIp();
        if (isset($ip)) {
            $this->db->where('ip', $ip);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $return = $row;
            }
        }
        

        $sql = $con->prepare("SELECT * FROM usuarios_online WHERE ip = ?");
        $sql->bind_param("s", $ip);
        $sql->execute();

        return $sql->get_result()->num_rows;
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

    public function getBlogById($id = 0)
    {
        return $this->getBlog(NULL, NULL, $id);
    }
    private function getBlog($title = NULL, $body = NULL, $id = 0)
    {
        $return = NULL;
        if (isset($title)) {
            safeInput($title);
            $this->db->where('news_title', $title);
            $query = $this->db->get($this->table, 1);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $return = $row;
            }
        }
        if (isset($body) && is_null($return)) {
            safeInput($body);
            $this->db->where('news_body', $body);
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



    /**
     * =================================
     *        REMOVE SE NÃO USAR
     * =================================
     */
}
