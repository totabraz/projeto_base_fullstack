<?php
    if(isset($this->session->userdata)) {
        if(isset($this->session->userdata['login'])) { $login = $this->session->userdata['login']; }
        if(isset($this->session->userdata['email'])) { $email = $this->session->userdata['email']; }
        if(isset($this->session->userdata['name'])) { $name = $this->session->userdata['name']; }
    }else{
        header("location: ".base_url()."admin/login");
    }
?>
  <div class="jumbotron jumbotron-fluid" style="background: #EEEEEE;">
    <div class="container">
      <h1 class="display-4" style="font-size: 44px;">Olá, <?php if(isset($name))  echo $name;?>
    </h1>
      <p class=""><big>Este espaço é dedicado ao evento <strong class="nome-evento">Congresso Internacional de Mediação e Justiça Restaurativa</strong> onde você poderá participar fazendo sua inscrição, cadastrando-se para minicurso, enviando artigos e, posteriormente, acessando o certificado..</big></p>
    </div>
  </div>
  
  <div class="container">
    <h1>Participe</h1>
    <div class="row">
      <div class="col-4">

        <a href="<?php echo base_url('dashboard/evento');?>" class="card o-card-link" style="background: #D2FFF0;border: 0px;">
          <div class="card-body" style="text-align: left;padding-bottom: 70px;">
            <h3 class="card-title">
                <small class="card-text" style="">Se inscrever no</small>
                <br/>Evento
            </h3>
          </div>
        </a>

      </div>
      <div class="col-4">

        <a href="<?php echo base_url('dashboard/minicursos');?>" class="card o-card-link" style="background: #D2FFF0;border: 0px;">
          <div class="card-body" style="text-align: left;padding-bottom: 70px;">
            <h3 class="card-title">
                <small class="card-text" style="">Se inscrever em</small>
                <br/>Minicursos</h3>
            
          </div>
        </a>

      </div>
      <div class="col-4">

        <a href="<?php echo base_url('dashboard/artigo');?>" class="card o-card-link" style="background: #D2FFF0;border: 0px;">
          <div class="card-body" style="text-align: left;padding-bottom: 70px;">
            <h3 class="card-title">
                <small class="card-text" style="">Submeter</small>
                <br/>Artigo</h3>
          </div>
        </a>

      </div>


    </div>
  </div>
