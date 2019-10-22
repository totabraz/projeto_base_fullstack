<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PortalConfigs extends CI_Controller
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
        $this->load->model('Portalconfigs_model', 'portalconfigs');
    }

    public function index()
    {
        redirect('admin/site/config/analytics', 'refresh');
    }

    public function analytics()
    {
        verificaLoginAdmin();

        // Regras de validação
        $this->form_validation->set_rules('google_analytics', 'Google Analytics', 'trim|required|min_length[20]');
        $msg = null;
        $dados = null;
        $dados['google_analytics'] = $this->portalconfigs->get_option('google_analytics');
        
        
        //verificar a validação 
        if ($this->form_validation->run() == false) {
            if (validation_errors()) $msg = getMsgError(validation_errors());
        } else if ($dados_form = $this->input->post()) {
            if ($this->portalconfigs->update_option('google_analytics', $dados_form['google_analytics'])) {
                $dados['google_analytics'] = $dados_form['google_analytics'];
                $msg = getMsgOk('Informações salvas com sucesso!');
            } else {
                $msg = getMsgError('Problemas ao salvar!');
            }
        }

        if (isset($msg)) set_msg($msg);

        $dados['title']     = 'Google Analytics';
        $dados['msg_system'] = (isset($msg)) ? $msg : '';

          // carrega view
          $this->load->view('admin/includes/head');
          $this->load->view('admin/includes/header', $dados);
          $this->load->view('admin/portal_configs/analytics', $dados);
          $this->load->view('admin/includes/footer');
    }

    public function contact() 
    {
        verificaLoginAdmin();

        $this->form_validation->set_rules('google_analytics', 'Google Analytics', 'trim|required|min_length[20]');
        $msg = null;
        $dados = null;
        $dados['google_analytics'] = $this->portalconfigs->get_option('google_analytics');
        printInfoDump($this->portalconfigs->get_all_option());


          // carrega view
          $this->load->view('admin/includes/head');
          $this->load->view('admin/includes/header', $dados);
          $this->load->view('admin/portal_configs/contact', $dados);
          $this->load->view('admin/includes/footer');
    }
}
