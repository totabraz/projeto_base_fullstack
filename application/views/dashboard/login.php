 <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">

          <?php 
				
				$setup = array('class' => 'form-control','trim|required');

				if ($msg = get_msg()) { echo $msg;  }

				echo form_open();
				echo '<div class="form-group">';
				// $opts = array('name'=>'login', 'value' => set_value('login'), 'title' => 'Infome seu Usuário','placeholder' => 'Usuário', 'autofocus'=>'autofocus');
				$opts = array('name'=>'login', 'title' => 'Infome seu Usuário','placeholder' => 'Usuário', 'autofocus'=>'autofocus' , 'value'=>'p0014671');
				echo form_input($opts,'',$setup);
				echo '</div>';

				echo '<div class="form-group">';
				$opts = array('name'=>'password', 'title' => 'Infome sua Senha','placeholder' => 'Senha', 'value'=>'poipoipoi');
				echo form_password($opts,'',$setup);
				echo '</div>';

				echo form_submit('enviar', 'Entrar'  , array('class' => 'btn btn-outline-info'));
            	// Form Closed
	            echo form_close();
				?>
        </div>
      </div>
    </div>




