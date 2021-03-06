<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        # Carregando o model
        // $this->load->model('Database_model');
        // # Carregando o model, configurando como um apelodo 
        // # Para poder chamar apenas como: 'Database'
        // $this->load->model('Database_model', 'Database');

        $this->load->helper('form');
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('option_model', 'option');
        $this->load->model('user_model', 'user');
    }


    public function index()
    {
        $table = 'options';
        if ($this->db->table_exists($table)) {
            if ($this->option->get_option('setup_executado' == 1)) {
                echo "setup_executado sim";
                redirect('admin/admin', 'refresh');
            } else {
                echo "setup_executado nao";
                redirect('setup/instalar', 'refresh');
            }
        } else {
            redirect('505', 'refresh');
        }
    }

    public function install()
    {
        // Regras de validação
        $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|min_length[8]');
        $this->form_validation->set_rules('full_name', 'Nome', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('phone', 'Telefone', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password2', 'Repitir Senha', 'trim|required|min_length[8]|matches[password]');
        $dados_form = $this->input->post();

        //verificar a validação 
        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                set_msg(getMsgError(validation_errors()));
            }
        } else {
            $user = NULL;
            if ($user = $this->user->getUserByLogin($dados_form['login']));
            else ($user = $this->user->getUserByEmail($dados_form['email']));

            if (($user === NULL) && (isset($dados_form['password']) && (isset($dados_form['password2']) && ($dados_form['password'] === $dados_form['password2'])))) {
                echo "chegou!!! 1111111";
                $dados_insert["login"] = $dados_form['login'];
                $dados_insert["email"] = $dados_form['email'];
                $dados_insert["full_name"] = $dados_form['full_name'];
                $dados_insert['permission_name'] = LABEL_ROOT;
                $dados_insert['permission_value'] = PERMISSION_ROOT;
                $dados_insert["password"] = password_hash($dados_form['password'], PASSWORD_DEFAULT);

                // salvar no banco
                if ($id = $this->user->save($dados_insert) && $this->option->update_option('setup_executado', 1)) {
                    set_msg(getMsgOk('Login cadstrado com sucesso!'));
                    $this->session->set_userdata('logged', true);
                    $this->session->set_userdata('login', $dados_form['login']);
                    $this->session->set_userdata('name', $dados_form['full_name']);
                    $this->session->set_userdata('email', $dados_form['email']);
                    $this->session->set_userdata('permission_name', LABEL_ROOT);
                    $this->session->set_userdata('permission_value', PERMISSION_ROOT);
                    redirect('admin/admin', 'refresh');
                } else {
                    set_msg(getMsgError('Problemas ao cadastrar usuário!'));
                }
            } else if ($user !== NULL) {
                set_msg(getMsgError('Login ou e-mail já cadastrado.. :('));
            } else {
                set_msg(getMsgError('Login já cadastrado!'));
            }
        }
        $dados['title']     = 'Novo Cadastro';
        $dados['user'] = (isset($dados_insert)) ?  $dados_insert : '';
        $dados['msg_system'] = (isset($msg)) ? $msg : '';

        $this->load->view('public/includes/head', $dados);
        $this->load->view('setup/setup', $dados);
        $this->load->view('public/includes/footer', $dados);
    }
}
