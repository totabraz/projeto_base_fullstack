<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Portalconfigs extends CI_Controller
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
    }

    public function index()
    {
        redirect('admin/site/config/analytics', 'refresh');
    }

    public function analytics()
    {
        verificaLoginAdmin();
        $this->load->model('portalconfigs_model', 'portalconfigs');

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
                $msg = getMsgError('Sem alterações...');
            }
        }

        if (isset($msg)) set_msg($msg);

        $dados['title']     = 'Google Analytics';
        $dados['menuActive']     = 'admin/analytics';
        $dados['msg_system'] = (isset($msg)) ? $msg : '';

        // carrega view
        $this->load->view('admin/includes/head');
        $this->load->view('admin/includes/header', $dados);
        $this->load->view('admin/portal_configs/analytics', $dados);
        $this->load->view('admin/includes/footer');
    }

    public function ads()
    {
        verificaLoginAdmin();
        $this->load->model('portalconfigs_model', 'portalconfigs');
        echo `<script data-ad-client="ca-pub-2438384457072155" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>`;
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
                $msg = getMsgError('Sem alterações...');
            }
        }

        if (isset($msg)) set_msg($msg);

        $dados['title']     = 'Ads';
        $dados['menuActive']     = 'admin/ads';
        $dados['msg_system'] = (isset($msg)) ? $msg : '';

        // carrega view
        $this->load->view('admin/includes/head');
        $this->load->view('admin/includes/header', $dados);
        $this->load->view('admin/portal_configs/ads', $dados);
        $this->load->view('admin/includes/footer');
    }

    public function contact()
    {
        verificaLoginAdmin();
        $this->load->model('portalcontact_model', 'contact');
        $dados['menuActive'] = ($this->uri->segment(4)) ? 'site/' . $this->uri->segment(4) : 'site/contato';        

        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|min_length[10]|valid_email');

        $dados['contact'] = $this->contact->getAll();
        $dados['contact'] = (array) $dados['contact'][0];
;
        $dados_form = $this->input->post();


        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                set_msg(getMsgError(validation_errors()));
            }
        } else if (isset($_POST['enviar'])) {
            $dados_insert['ID'] = 1;
            if (isset($dados_form['email'])) {
                $dados_insert['email']  = $dados_form['email'];
                $dados['contact']['email']  = $dados_form['email'];
            }
            if (isset($dados_form['telefone'])) {
                $dados_insert['telefone']  = $dados_form['telefone'];
                $dados['contact']['telefone']  = $dados_form['telefone'];
            }
            if (isset($dados_form['ramal'])) {
                $dados_insert['ramal']  = $dados_form['ramal'];
                $dados['contact']['ramal']  = $dados_form['ramal'];
            }
            if (isset($dados_form['whatsapp'])) {
                $dados_insert['whatsapp']  = $dados_form['whatsapp'];
                $dados['contact']['whatsapp']  = $dados_form['whatsapp'];
            }
            if (isset($dados_form['facebook'])) {
                $dados_insert['facebook']  = $dados_form['facebook'];
                $dados['contact']['facebook']  = $dados_form['facebook'];
            }
            if (isset($dados_form['instagram'])) {
                $dados_insert['instagram']  = $dados_form['instagram'];
                $dados['contact']['instagram']  = $dados_form['instagram'];
            }
            if (isset($dados_form['twitter'])) {
                $dados_insert['twitter']  = $dados_form['twitter'];
                $dados['contact']['twitter']  = $dados_form['twitter'];
            }
            if (isset($dados_form['youtube'])) {
                $dados_insert['youtube']  = $dados_form['youtube'];
                $dados['contact']['youtube']  = $dados_form['youtube'];
            }
            if (isset($dados_form['linkedin'])) {
                $dados_insert['linkedin']  = $dados_form['linkedin'];
                $dados['contact']['linkedin']  = $dados_form['linkedin'];
            }
            if (isset($dados_form['behance'])) {
                $dados_insert['behance']  = $dados_form['behance'];
                $dados['contact']['behance']  = $dados_form['behance'];
            }
            if (isset($dados_form['endereco'])) {
                $dados_insert['endereco']  = $dados_form['endereco'];
                $dados['contact']['endereco']  = $dados_form['endereco'];
            }
            if (isset($dados_form['google_maps'])) {
                $dados_insert['google_maps']  = $dados_form['google_maps'];
                $dados['contact']['google_maps']  = $dados_form['google_maps'];
            }
            
            if ($this->contact->save($dados_insert)) {
                set_msg(getMsgOk('Informações salvas com sucesso!'));
            } else {
                set_msg(getMsgError('Sem alterações...'));
            }
        }

        $dados['contact'] = (array) $dados['contact'];

        // carrega view
        $this->load->view('admin/includes/head');
        $this->load->view('admin/includes/header', $dados);
        $this->load->view('admin/portal_configs/contact', $dados);
        $this->load->view('admin/includes/footer');
    }
}
