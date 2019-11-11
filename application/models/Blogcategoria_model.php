<?php
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */
/** Versão nova -  Versão nova  -  Versão nova -  Versão nova */

defined('BASEPATH') or exit('No direct script access allowed');

class Blogcategoria_model extends CI_Model
{
    var $table = 'blog_categoria';

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
            'blog_categoria_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'blog_categoria' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            )
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

    public function getBlogCategoriaById($id = 0)
    {
        return $this->getBlogCategoria(NULL, NULL, $id);
    }
    private function getBlogCategoria($title = NULL, $body = NULL, $id = 0)
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

	public function remove($id = 0){
		$this->db->where('id',$id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}


    /**
     * =================================
     *        REMOVE SE NÃO USAR
     * =================================
     */
}
