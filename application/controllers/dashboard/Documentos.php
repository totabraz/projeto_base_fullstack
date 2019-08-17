<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentos extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('option_model', 'option');
		$this->load->model('documento_model','documentos');
	}

	private function getMsgFormError($msg = NULL){
		$startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><p>';
		$endOfAlert = '</p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';	
		if (isset($msg)){
			$msgfinal ='';
			return $startOfAlert. $msg . $endOfAlert;
		} else if (validation_errors()){
			// Erros recebidos pelo envio. -> com os um estilo pré definido estilos
			return validation_errors($startOfAlert, $endOfAlert);	
		}
	}

	private function getMsgUploadFileError($msg = NULL){
		$startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><p>';
		$endOfAlert = '</p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';	
		if (isset($msg)){
			$msgfinal ='';
			return $startOfAlert. $msg . $endOfAlert;
		} else if (validation_errors()){
			// Erros recebidos pelo envio. -> com os um estilo pré definido estilos
			return validation_errors($startOfAlert, $endOfAlert);	
		}
	}

	public function index() {
		// $this->load->view('welcome_message');
		redirect('dashboard/documentos/buscar', 'refresh');
	}
	
	public function listar() {
		// Verificar login da sessão
		verificaLogin();
		// carrega view
		$config = array(
			"per_page" => 10,
			"num_links" => 3,
			"uri_segment" => 3,
			'use_page_numbers' => TRUE,
			'page_query_string' => TRUE,
			"total_rows" => $this->documentos->countAll(),
			"full_tag_open" => '<nav aria-label="..."><ul class="pagination">',
			"full_tag_close" => "</ul></nav>",
			'first_url' => base_url('dashboard/documentos').'?'.http_build_query($_GET),
			"last_link" => FALSE,
			"first_tag_open" => "<li>",
			"first_tag_close" => "</li>",
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
		$this->pagination->initialize($config);
		$dados['paginacao'] = $this->pagination->create_links();

		$dados['title'] =  'Listagem de Documentos';
		$dados['subtitle'] =  'Listagem do notícias';
		$dados['tela'] =  'listar';
		$dados['sidenav'] = 'list-doc';
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$dados['documentos'] = $this->documentos->getAll('titulo',$config['per_page'],$offset);

		$this->load->view('dashboard/includes/head', $dados);
		$this->load->view('dashboard/includes/side-nav.php', $dados);
		$this->load->view('dashboard/documentos', $dados);
		$this->load->view('includes/footer', $dados);
	}

	public function cadastrar() {
		// Verificar login da sessão
		verificaLogin();
		// regras de validação
		$this->form_validation->set_rules('titulo', 'Título', 'required|required');
		$this->form_validation->set_rules('autor', 'Autor', 'required|required');
		$this->form_validation->set_rules('orientador', 'rientador', 'required|required');
		$this->form_validation->set_rules('resumo', 'Resumo', 'required|required');
		$this->form_validation->set_rules('abstract', 'Abstract', 'required|required');
		$this->form_validation->set_rules('tipo_doc', 'Tipo do documento', 'required|required');
		$this->form_validation->set_rules('idioma', 'Idioma', 'required|required');
		$this->form_validation->set_rules('data_defesa', 'Data da defesa', 'required|required');
		$this->form_validation->set_rules('keywords', 'Plavras Chave', 'required|required');
		//verificar a validação 
		if($this->form_validation->run() == FALSE) {
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
				$dados_insert["orientador"] = $dados_form["orientador"];
				$dados_insert["resumo"] = $dados_form["resumo"];
				$dados_insert["abstract"] = $dados_form["abstract"];
				$dados_insert["tipo_doc"] = $dados_form["tipo_doc"];
				$dados_insert["idioma"] = $dados_form["idioma"];
				$dados_insert["data_defesa"] = changeDateToDB($dados_form["data_defesa"]);
				$dados_insert["arquivo"] = $dados_upload["file_name"];
				$dados_insert["keywords"] = removeSpaces($dados_form["keywords"]);

				// salvar no banco
				if ($id = $this->documentos->salvar($dados_insert)) {
					$msg = set_msg(getMsgOk('Documento cadstrada com sucesso!'));
					redirect('dashboard/documentos/editar/'. $id,'refresh');
				} else { 
					$msg = set_msg(getMsgOk('Erro! Documento não cadastrada!'));
				}
				$msg;
			} else {
				$startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><p>';
				$endOfAlert = '</p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';	
				$config = config_upload();
				$msg = $this->upload->display_errors($startOfAlert, $endOfAlert);
				$msg .= $startOfAlert . 'São permitidos arquivos PDF, DOCX ou DOC de até '. ($config['max_size'] / 1024). 'MB' . $endOfAlert;
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

	public function excluir(){
		// Verificar login da sessão
		verificaLogin();
		$idDocumento = $this->uri->segment(4);
		if ($idDocumento > 0){
			if($documento = $this->documentos->getDocumento($idDocumento)){
				$dados['documento'] = $documento;
			} else {
				set_msg(getMsgError('Erro! Documento inexistente! Escolha um documento para excluir !'));
				redirect('dashboard/documentos/listar','refresh');
			}
		} else {
			set_msg(getMsgError('Erro! ID_Documento não encontrado!'));
			redirect('dashboard/documentos/listar','refresh');
		}
		$this->form_validation->set_rules('excluir', 'Excluir', 'trim|required'); 
		//verificar a validação 
		if($this->form_validation->run() == FALSE) {
			if (validation_errors()) {
				set_msg($this->getMsgFormError());
			}
		} else {
			$arquivoPath = 'uploads/' . $documento->arquivo;
			if ($this->documentos->excluirDocumento($idDocumento)){
				unlink($arquivoPath);
				set_msg(getMsgOk('Documento excluida com sucesso!'));
				redirect('dashboard/documentos/listar','refresh');
			} else {
				set_msg(getMsgError('Nenhum documento foi excluida!'));
				redirect('dashboard/documentos/listar','refresh');
			}
		}

		// carrega view
		$dados['title']		=  'Listagem de Documentos';
		$dados['subtitle']  =  'Excluir do notícias';
		$dados['tela'] 		=  'excluir';
		$dados['sidenav'] = 'edit-doc';
		$this->load->view('dashboard/includes/head', $dados);
		$this->load->view('dashboard/includes/side-nav.php', $dados);
		$this->load->view('dashboard/documentos', $dados);
		$this->load->view('includes/footer', $dados);
	}

	public function editar(){
		// Verificar login da sessão
		verificaLogin();
		//Verifica se o ID foi passado
		$idDocumento = $this->uri->segment(4);
		if ($idDocumento > 0){
			// ID informado, continuar a edição
			if($documento = $this->documentos->getDocumento($idDocumento)) {
				$dados['documento'] = $documento;
				$dados_update['id'] = $documento->id;
			} else {
				set_msg(getMsgError('Erro! Documento inexistente!<br/> Escolha um documento para editar !'));
				redirect('dashboard/documentos/listar','refresh');
			}
		} else {
			set_msg(getMsgError('Erro! ID_Documento não encontrado!'));
			redirect('dashboard/documentos/listar','refresh');
		}
		// regras de validação
		$this->form_validation->set_rules('titulo', 'Título', 'required|required');
		$this->form_validation->set_rules('autor', 'Autor', 'required|required');
		$this->form_validation->set_rules('orientador', 'Orientador', 'required|required');
		$this->form_validation->set_rules('resumo', 'Resumo', 'required|required');
		$this->form_validation->set_rules('abstract', 'Abstract', 'required|required');
		$this->form_validation->set_rules('tipo_doc', 'Tipo do documento', 'required|required');
		$this->form_validation->set_rules('idioma', 'Idioma', 'required|required');
		$this->form_validation->set_rules('data_defesa', 'Data da defesa', 'required|required');

		//verificar a validação 
		if($this->form_validation->run() == FALSE) {
			if (validation_errors()) {
				set_msg($this->getMsgFormError());
			}
		} else {
			//  library upload_files
			$this->load->library('upload', config_upload());
			if( isset($_FILES['arquivo']) && $_FILES['arquivo']['name'] != ''){
				// foi enviada uma arquivo, devo fazer o upload
				if ($this->upload->do_upload('arquivo')) {
					// upload foi efetuado
					$img_antiga = 'uploads/' . $documento->arquivo;
					$dados_upload = $this->upload->data();
					$dados_form = $this->input->post();
					$dados_update["titulo"] = $dados_form["titulo"];
					$dados_update["autor"] = $dados_form["autor"];
					$dados_update["orientador"] = $dados_form["orientador"];
					$dados_update["resumo"] = $dados_form["resumo"];
					$dados_update["abstract"] = $dados_form["abstract"];
					$dados_update["tipo_doc"] = $dados_form["tipo_doc"];
					$dados_update["idioma"] = $dados_form["idioma"];
					$dados_update["data_defesa"] = changeDateToDB($dados_form["data_defesa"]);
					$dados_update["arquivo"] = $dados_upload["file_name"];
					if ($this->documentos->salvar($dados_update)){
						unlink($img_antiga);
						set_msg(getMsgOk('Documento alterado com sucesso!'));
						$dados['documento']->arquivo = $dados_update['arquivo'];
					} else {
						set_msg(getMsgError('Ops! Nenhum documento foi alterado!'));
					}
				} else {
					//  erro no upload
					$config = config_upload();
					$startOfAlert = '<div class="form-group alert alert-danger alert-dismissible fade show" role="alert"><p>';
					$endOfAlert = '</p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';	
					$msg = $this->upload->display_errors($startOfAlert, $endOfAlert);
					$msg .= $startOfAlert . 'São permitidos arquivos JPG e PNG de até '. ($config['max_size'] / 1024). 'MB' . $endOfAlert;
					set_msg($msg);
				}
			} else {
				// não foi envada uma arquivo pelo form 
				$dados_form = $this->input->post();
				$dados_update["titulo"] = $dados_form["titulo"];
				$dados_update["autor"] = $dados_form["autor"];
				$dados_update["orientador"] = $dados_form["orientador"];
				$dados_update["resumo"] = $dados_form["resumo"];
				$dados_update["abstract"] = $dados_form["abstract"];
				$dados_update["tipo_doc"] = $dados_form["tipo_doc"];
				$dados_update["idioma"] = $dados_form["idioma"];
				$dados_update["data_defesa"] = changeDateToDB($dados_form["data_defesa"]);
				if ($this->documentos->salvar($dados_update)){
					set_msg(getMsgOk('Documento alterado com sucesso!'));
				} else {
					set_msg(getMsgError('Ops! Nenhum documento foi alterado!')); 
				}
			}
		}
		// carrega view
		$dados['title']		=  'Listagem de Documentos';
		$dados['subtitle']  =  'Alteração do notícias';
		$dados['tela'] 		=  'editar';
		$dados['sidenav'] = 'edit-doc';

		$this->load->view('dashboard/includes/head', $dados);
		$this->load->view('dashboard/includes/side-nav.php', $dados);
		$this->load->view('dashboard/documentos', $dados);
		$this->load->view('includes/footer', $dados);
	}	

	public function buscar(){
		// Verificar login da sessão
		verificaLogin();

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
			'first_url' => base_url('dashboard/documentos/buscar').'?per_page=1' . $param_from_get,
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

		$this->load->view('dashboard/includes/head', $dados);
		$this->load->view('dashboard/includes/side-nav.php', $dados);
		$this->load->view('dashboard/documentos/busca.php', $dados);
		$this->load->view('includes/footer', $dados);
	}
}























