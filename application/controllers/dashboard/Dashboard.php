<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        if ($this->option->get_option('setup_executado' == 1)) {
            redirect('dashboard/home', 'refresh');
        } else {
            redirect('setup/instalar', 'refresh');
        }
    }

    public function logout()
    {
        // Destroy os dados da sessão
        setSessionnOff();
        set_msg(getMsgError('Você saiu do sistema!'));
        redirect(base_url(), 'refresh');
    }

    private function getMsgFormError($msg = null)
    {
        $startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><span>';
        $endOfAlert = '</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        if (isset($msg)) {
            return $startOfAlert . 'Operação realizada' . $endOfAlert;
        } else if (validation_errors()) {
            // Erros recebidos pelo envio. -> com os um estilo pré definido estilos
            return validation_errors($startOfAlert, $endOfAlert);
        }
    }

    public function alterar()
    {
        // Verifica login do usuário
        verificaLogin();
        //Regras de validacão
        $this->form_validation->set_rules('login', 'Usuário', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|min_length[8]');
        $this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
        if (isset($_POST['password']) && $_POST['password'] != '') {
            $this->form_validation->set_rules('password2', 'Repitir Senha', 'trim|min_length[8]|matches[password]');
        }
        // Verifica a validacão
        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                set_msg($this->getMsgFormError());
            }
        } else {
            $dados_form = $this->input->post();
            $this->option->update_option('user_email', $dados_form['email']);
            $this->option->update_option('user_login', $dados_form['login']);
            if (isset($dados_form['password']) && $dados_form['password'] != '') {
                $this->option->update_option('user_password', password_hash($dados_form['password'], PASSWORD_DEFAULT));
            }
            set_msg(getMsgOk('Dados alterados com sucesso! :D'));
        }

        //carrega as views
        $dados['title'] = 'Acesso ao sistema';
        $dados['subtitle'] = 'Alterar configuração básica';

        $_POST['login'] = $this->option->get_option('user_login');
        $_POST['email'] = $this->option->get_option('user_email');

        $this->load->view('public/includes/head', $dados);
        $this->load->view('dashboard/setup', $dados);
        $this->load->view('public/includes/footer', $dados, $dados);
    }

    public function artigo()
    {

        // Verificar login da sessão
        verificaLogin();
        // regras de validação
        $this->form_validation->set_rules('titulo', 'Título', 'required|required');
        $this->form_validation->set_rules('autor', 'Autor', 'required|required');
        $this->form_validation->set_rules('coautor', 'coAutor', 'required|required');
        $this->form_validation->set_rules('idioma', 'Idioma', 'required|required');
        //verificar a validação 
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                set_msg($this->getMsgFormError());
            }
        } else {
            $this->load->library('upload', config_upload());
            // o parâmetro da funcão é o 'name'=>'arquivo' do campo no form.
            if ($this->upload->do_upload('arquivo')) {
                $dados_upload = $this->upload->data();
                $dados_form = $this->input->post();
                $dados_insert["titulo"] = $dados_form["titulo"];
                $dados_insert["autor"] = $dados_form["autor"];
                $dados_insert["coautor"] = $dados_form["coautor"];
                $dados_insert["idioma"] = $dados_form["idioma"];
                $dados_insert["data_defesa"] = changeDateToDB($dados_form["data_defesa"]);
                $dados_insert["arquivo"] = $dados_upload["file_name"];
                $dados_insert["keywords"] = removeSpaces($dados_form["keywords"]);

                // salvar no banco
                if ($id = $this->documentos->salvar($dados_insert)) {
                    $msg = set_msg(getMsgOk('Documento cadstrada com sucesso!'));
                    redirect('dashboard/documentos/editar/' . $id, 'refresh');
                } else {
                    $msg = set_msg(getMsgOk('Erro! Documento não cadastrada!'));
                }
                $msg;
            } else {
                $startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><p>';
                $endOfAlert = '</p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $config = config_upload();
                $msg = $this->upload->display_errors($startOfAlert, $endOfAlert);
                $msg .= $startOfAlert . 'São permitidos arquivos PDF, DOCX ou DOC de até ' . ($config['max_size'] / 1024) . 'MB' . $endOfAlert;
                set_msg($msg);
            }
        }
        // carrega view
        $dados['title'] =  'cadastrar de Documentos';
        $dados['subtitle'] =  'Cadastrar do notícia';
        $dados['tela'] =  'cadastrar';
        $dados['sidenav'] = 'edit-doc';
        $this->load->view('dashboard/includes/head', $dados);
        $this->load->view('dashboard/includes/side-nav.php', $dados);
        $this->load->view('dashboard/documentos', $dados);
        $this->load->view('includes/footer', $dados);
    }

    public function evento()
    {
        $this->load->view('public/includes/head', $dados);
        $this->load->view('dashboard/evento', $dados);
        $this->load->view('public/includes/footer', $dados, $dados);
    }

    public function minicurs()
    { }

    // public function instalar(){
    //     redirect('cadastrar', 'refresh');
    // }
    // public function cadastrar()
    // {
    //     // Regras de validação
    //     $this->form_validation->set_rules('login', 'Usuário', 'trim|required|min_length[5]');
    //     $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|min_length[8]');
    //     $this->form_validation->set_rules('fist_name', 'Nome', 'trim|required|min_length[5]');
    //     $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]');
    //     $this->form_validation->set_rules('phone', 'Telefone', 'trim|required|min_length[5]');
    //     $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[8]');
    //     $this->form_validation->set_rules('password2', 'Repitir Senha', 'trim|required|min_length[8]|matches[password]');
    //     $dados_form = $this->input->post();
    //     $dados_insert = $dados_form;
    //     unset($dados_insert['password2']);
    //     unset($dados_insert['enviar']);

    //     //verificar a validação 
    //     if ($this->form_validation->run() == false) {
    //         if (validation_errors()) {
    //             set_msg($this->getMsgFormError());
    //         }
    //     } else {
    //         $user = $this->user->getUser($dados_form['login']);
    //         $email = $this->user->getUser($dados_form['email']);
    //         if (($user === null && $email === null) && (isset($dados_form['password']) && (isset($dados_form['password2']) && ($dados_form['password'] === $dados_form['password2'])))) {
    //             $dados_insert["login"] = $dados_form['login'];
    //             $dados_insert["email"] = $dados_form['email'];
    //             $dados_insert["fist_name"] = $dados_form['fist_name'];
    //             $dados_insert["last_name"] = $dados_form['last_name'];
    //             $dados_insert["password"] = password_hash($dados_form['password'], PASSWORD_DEFAULT);

    //             // salvar no banco
    //             if ($id = $this->user->salvar($dados_insert)) {
    //                 $msg = set_msg(getMsgOk('Usuário cadstrado com sucesso!'));
    //                 $this->session->set_userdata('logged', true);
    //                 $this->session->set_userdata('login', $dados_form['login']);
    //                 $this->session->set_userdata('name', $dados_form['fist_name']);
    //                 $this->session->set_userdata('email', $dados_form['login']);
    //                 // redirect('dashboard/home', 'refresh');
    //             } else {
    //                 $msg = set_msg(getMsgError('Problemas ao cadastrada usuário!'));
    //             }
    //         } else if ($user !== null) {
    //             $msg = set_msg(getMsgError('Login já cadastrado!'));
    //         } else if ($email !== null) {
    //             $msg = set_msg(getMsgError('Email já cadastrado!'));
    //         } else {
    //             $msg = set_msg(getMsgError('Usuário já cadastrado!'));
    //         }
    //     }
    //     $dados['title']     = 'Novo Cadastro';
    //     $dados['user'] = $dados_insert;
    //     $this->load->view('public/includes/head', $dados);
    //     $this->load->view('setup/setup', $dados);
    //     $this->load->view('public/includes/footer', $dados);
    // }

    public function perfil()
    {
        // Verifica login do usuário
        verificaLogin();
        $user = $this->user->getMyUserInfo();
        $userFinal = $this->user->getUser($user->login);
        //Regras de validacão
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|min_length[8]');
        $this->form_validation->set_rules('fist_name', 'Nome', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('phone', 'Telefone', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');

        if (isset($_POST['password']) && $_POST['password'] != '') {
            $this->form_validation->set_rules('password2', 'Repitir Senha', 'trim|min_length[8]|matches[password]');
        }

        // Verifica a validacão
        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                set_msg($this->getMsgFormError());
            }
        } else {
            $dados_form = $this->input->post();
            if ((isset($dados_form['login']) && $dados_form['login'] !== '')) {
                $userFinal->login = $dados_form['login'];
            }
            if ((isset($dados_form['email']) && $dados_form['email'] !== '')) {
                $userFinal->email = $dados_form['email'];
            }
            if ((isset($dados_form['fist_name']) && $dados_form['fist_name'] !== '')) {
                $userFinal->fist_name = $dados_form['fist_name'];
            }
            if ((isset($dados_form['last_name']) && $dados_form['last_name'] !== '')) {
                $userFinal->last_name = $dados_form['last_name'];
            }
            if ((isset($dados_form['phone']) && $dados_form['phone'] !== '')) {
                $userFinal->phone = $dados_form['phone'];
            }

            if (isset($dados_form['password']) && $dados_form['password'] != '') {
                if ($dados_form['password'] === $dados_form['password2']) {
                    $userFinal->password = password_hash($dados_form['password'], PASSWORD_DEFAULT);
                } else {
                    set_msg(getMsgError('Senhas não coferem!'));
                }
            }
            $this->user->salvar($userFinal);
            set_msg(getMsgOk('Dados alterados com sucesso! :D'));
        }

        $dados['title']     = 'Novo Cadastro';
        $dados['user'] = $userFinal;

        $this->load->view('public/includes/head', $dados);
        $this->load->view('dashboard/includes/header', $dados);
        $this->load->view('dashboard/perfil', $dados);
        $this->load->view('public/includes/footer', $dados);
    }

    public function login()
    {
        if ($this->option->get_option('setup_executado') != 1) {
            redirect('setup/instalar', 'refresh');
        } else {
            $this->form_validation->set_rules('login', 'Usuário', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[8]');
            // verifica validação
            if ($this->form_validation->run() == false) {
                if (validation_errors()) {
                    set_msg($this->getMsgFormError());
                }
            } else {
                $dados_form = $this->input->post();
                $user = null;
                //if find by login
                if ($user = $this->user->getUser($dados_form['login'])) {
                    if ($user->login === $dados_form['login']) {
                        if (password_verify($dados_form['password'], $user->password)) {
                            $this->session->set_userdata('logged', true);
                            $this->session->set_userdata('login', $user->login);
                            $this->session->set_userdata('email', $user->email);
                            $this->session->set_userdata('name', $user->fist_name);
                            //TODO: fazer difect para
                            redirect('dashboard/home', 'refresh');
                        } else {
                            set_msg(getMsgError('Login ou senha incorreta! :('));
                        }
                    }
                    //if find by email
                } else if ($user = $this->user->getUser($dados_form['login'])) {
                    if ($user->email === $dados_form['login']) {
                        if (password_verify($dados_form['password'], $user->password)) {
                            setSessionnOn($user);

                            //TODO: fazer difect para
                            redirect('dashboard/home', 'refresh');
                        } else {
                            set_msg(getMsgError('Email ou senha incorreta! :('));
                        }
                    }
                } else {
                    set_msg(getMsgError('Usurário não existe! :('));
                }
            }
            $dados['title'] = 'Acesso ao sistema';
            $dados['subtitle'] = 'Acessar o painel';
            $this->load->view('public/includes/head', $dados);
            $this->load->view('dashboard/login', $dados);
            $this->load->view('public/includes/footer', $dados);
        }
    }

    public function home()
    {
        // Verificar login da sessão
        verificaLogin();
        $dados['title']     = 'Novo Cadastro';
        $this->load->view('public/includes/head', $dados);
        $this->load->view('dashboard/includes/header', $dados);
        $this->load->view('dashboard/home', $dados);
        $this->load->view('public/includes/footer', $dados);
    }
}
