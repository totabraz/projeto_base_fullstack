<?php
 /*
<pre>
    $array = ['fist_name', 'last_name', 'login', 'email', 'password', 'phone', 'user_type', 'user_level', 'blocked'];
    foreach ($array as $item){
        echo '<br>';
        echo "echo '";
        echo ' &#60;div class=';
        echo '"form-group"';
        echo ">';";
        
        echo '<br>';
        echo "$";
        echo "opts = array('name'=>$". $item . ", 'value' => $";
        echo $item . " ";
        echo ", 'title' => 'Infome seu $item');";
        
        echo '<br>';
        echo "echo form_label('".$item.":');";
        echo '<br>';
        echo "echo form_input($";
        echo "opts,'',$";
        echo "setup);";
        
        echo '<br>';
        echo "echo '&#60;/div>';";
        
        echo '<br>';
        echo '<br>';
        echo '<br>';
    }
</pre>
*/
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 header-area">
                <h1 class="col-12 main-title">
                    <span>Configurações</span>
                </h1>
            </div>
            <div class="col col-sm-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        $setup = array('class' => 'form-control', 'trim|required');
                        $setupNotRequired = array('class' => 'form-control');

                        if ($msg = get_msg()) {
                            echo $msg;
                        }

                        echo form_open();

                        echo '<div class="form-group">';
                        echo form_label('Usuário: ' . $user->login);
                        echo '</div>';

                        echo ' <div class="form-group">';
                        $opts = array('name' => 'fist_name', 'value' => $user->fist_name, 'title' => 'Infome seu Nome');
                        echo form_label('Nome:');
                        echo form_input($opts, '', $setup);
                        echo '</div>';

                        echo ' <div class="form-group">';
                        $opts = array('name' => 'last_name', 'value' => $user->last_name, 'title' => 'Infome seu Sobrenome');
                        echo form_label('Sobrenome:');
                        echo form_input($opts, '', $setup);
                        echo '</div>';

                        echo ' <div class="form-group">';
                        $opts = array('name' => 'email', 'value' => $user->email, 'title' => 'Infome seu E-mail');
                        echo form_label('email:');
                        echo form_input($opts, '', $setup);
                        echo '</div>';


                        echo ' <div class="form-group">';
                        $opts = array('name' => 'phone', 'value' => $user->phone, 'title' => 'Infome seu Telefone');
                        echo form_label('Telefone:');
                        echo form_input($opts, '', $setup);
                        echo '</div>';

                        echo '<div class="form-group">';
                        $opts = array('name' => 'password', 'title' => 'Infome sua Senha', 'class' => 'form-control',  'placeholder' => 'Senha', 'value' => '');
                        echo form_label('Deixar em branco, para não editar');
                        echo form_password($opts, '', '');
                        echo '</div>';

                        echo '<div class="form-group">';
                        $opts = array('name' => 'password2', 'title' => 'Repita sua Senha', 'class' => 'form-control', 'placeholder' => 'Repitir Senha', 'value' => '');
                        echo form_password($opts, '', '');
                        echo '</div>';

                        echo form_submit('enviar', 'Registrar', array('class' => 'btn btn-outline-info'));
                        // Form Closed
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 