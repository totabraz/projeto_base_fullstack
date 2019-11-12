<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicblog extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		# Carregando o model
		// $this->load->model('Database_model');
		// # Carregando o model, configurando como um apelodo 
		// # Para poder chamar apenas como: 'Database'
		// $this->load->model('Database_model', 'Database');
		$this->load->helper('url');
		$this->load->model('option_model', 'option');
		$this->load->model('documento_model', 'documentos');
	}
	
	public function index(){
		redirect('blog', 'refresh');
    }
    
	public function buscar(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('documento_model','documentos');
		// Verificar login da sessão

		$per_page = 10;	
		$param_from_get = '';
		$offset_aux = 10;
		$offset = null;
		if(isset($_GET['per_page'])) { $offset = ($_GET['per_page']>1)? ($_GET['per_page'] * $offset_aux) - $offset_aux : 0; }
		$dados['$form_preenchido'] = null;

		// regras de validação
		$this->form_validation->set_rules('titulo', 'Título');
		$this->form_validation->set_rules('autor', 'Título');
		$this->form_validation->set_rules('orientador', 'Título');
		$this->form_validation->set_rules('tipo_doc', 'Tipo do documento');
		$this->form_validation->set_rules('idioma', 'Idioma');
		$this->form_validation->set_rules('data_defesa', 'Data da defesa');
		$this->form_validation->set_rules('ano_defesa', 'Ano da defesa');

		if ($dados_form = $this->input->post()){
			$titulo = rtrim(preg_replace('/\s+/', ' ',$dados_form["titulo"]));
			$autor = rtrim(preg_replace('/\s+/', ' ',$dados_form["autor"]));
			$orientador = rtrim(preg_replace('/\s+/', ' ',$dados_form["orientador"]));
			$tipo_doc  = $dados_form["tipo_doc"];
			$idioma  = $dados_form["idioma"];
			$data_defesa  = changeDateToDB($dados_form["data_defesa"]);
			$ano_defesa  = $dados_form["ano_defesa"];
		} else {
			$titulo = (isset($_GET['titulo'])) ? $_GET['titulo'] : null;
			$autor = (isset($_GET['autor'])) ? $_GET['autor'] : null;
			$orientador = (isset($_GET['orientador'])) ? $_GET['orientador'] : null;
			$tipo_doc = (isset($_GET['tipo_doc'])) ? $_GET['tipo_doc'] : null;
			$idioma = (isset($_GET['idioma'])) ? $_GET['idioma'] : null;
			$data_defesa = (isset($_GET['data_defesa'])) ? $_GET['data_defesa'] : null;
			$ano_defesa = (isset($_GET['ano_defesa'])) ? $_GET['ano_defesa'] : null;
			
			if (isset($titulo)) { $param_from_get .= '&titulo='.$_GET['titulo']; }
			if (isset($autor)) { $param_from_get .= '&autor='.$_GET['autor']; }
			if (isset($orientador)) { $param_from_get .= '&orientador='.$_GET['orientador']; }
			if (isset($tipo_doc)) { $param_from_get .= '&tipo_doc='.$_GET['tipo_doc']; }
			if (isset($idioma)) { $param_from_get .= '&idioma='.$_GET['idioma']; }
			if (isset($data_defesa)) { $param_from_get .= '&data_defesa='.$_GET['data_defesa']; }
			if (isset($ano_defesa)) { $param_from_get .= '&ano_defesa='.$_GET['ano_defesa']; }
		}

		$form_preenchido = 0;
		if (isset($titulo) && $titulo!='') { 
			$param_from_get .= '&titulo=' . $titulo; 
			$form_preenchido++;
		}
		if (isset($autor) && $autor!='') { 
			$param_from_get .= '&autor=' . $autor; 
			$form_preenchido++;
		}
		if (isset($orientador) && $orientador!='') {
			$param_from_get .= '&orientador=' . $orientador; 
			$form_preenchido++;
		}
		if (isset($tipo_doc) && $tipo_doc!='') { 
			$param_from_get .= '&tipo_doc=' . $tipo_doc; 
			$form_preenchido++;
		}
		if (isset($idioma) && $idioma!='') { 
			$param_from_get .= '&idioma=' . $idioma; 
			$form_preenchido++;
		}
		if (isset($data_defesa) && $data_defesa!='') {
			$param_from_get .= '&data_defesa=' . changeDateToDB($data_defesa); 
			$form_preenchido++;
		}
		if (isset($ano_defesa) && $ano_defesa!='') {
			$param_from_get .= '&ano_defesa=' . $ano_defesa; 
			$form_preenchido++;
		}
		

		$dados['documentos'] = $this->documentos->searchDocumento($titulo, $autor, $orientador, $data_defesa, $tipo_doc, $idioma, $ano_defesa, $offset, $per_page);

		$config = array(
			"per_page" => 10,
			"num_links" => 3,
			"uri_segment" => 3,
			'use_page_numbers' => TRUE,
			'page_query_string' => TRUE,
			"total_rows" => $this->documentos->countAllFiltred($titulo, $autor, $orientador, $data_defesa, $tipo_doc, $idioma, $ano_defesa),
			"full_tag_open" => '<nav aria-label="..."><ul class="pagination">',
			"full_tag_close" => "</ul></nav>",
			'first_url' => base_url('buscar').'?per_page=1' . $param_from_get,
			"last_link" => FALSE,
			"first_tag_open" => "<li class='page-item'><span class='page-link' href='#'>",
			"first_tag_close" => "</span></li>",
			'suffix' => $param_from_get,
			"prev_link" => "Anterior",
			"prev_tag_open" => "<li class='page-item'><span class='page-link' href='#'>",
			"prev_tag_close" => "</span></li>",
			"next_link" => "Próxima",
			"next_tag_open" => "<li class='page-item'><span class='page-link' href='#'>",
			"next_tag_close" => "</span></li>",
			"last_tag_open" => "<li class='page-item'><span class='page-link' href='#'>",
			"last_tag_close" => "</span></li>",
			"cur_tag_open" => "<li class='active'><span class='page-link' href='#'>",
			"cur_tag_close" => "</span></li>",
			"num_tag_open" => "<li class='page-item'><span class='page-link' href='#'>",
			"num_tag_close" => "</span></li>"
		);

		$dados['titulo'] = $titulo;
		$dados['autor'] = $autor;
		$dados['orientador'] = $orientador;
		$dados['tipo_doc'] = $tipo_doc;
		$dados['idioma'] = $idioma;
		$dados['data_defesa'] = $data_defesa;
		$dados['ano_defesa'] = $ano_defesa;
		$dados['form_preenchido'] = $form_preenchido;

		$dados['form'] = $this->pagination->initialize($config);
		$dados['paginacao'] = $this->pagination->create_links();
		$dados['title'] =  'Listagem de Documentos';
		$dados['subtitle'] =  'Listagem do notícias';
		$dados['tela'] =  'buscar';
		$dados['sidenav'] = 'buscar-doc';

		$this->load->view('includes/head', $dados);
		$this->load->view('documentos/buscar', $dados);
		$this->load->view('includes/footer', $dados);
	}
	

	public function blog() {
		$dados = '';
		$this->load->view('public/includes/head', $dados);
		// $this->load->view('documentos/blog', $dados);
		$this->load->view('public/includes/footer', $dados);	
	}
}
