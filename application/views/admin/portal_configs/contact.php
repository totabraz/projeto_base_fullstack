<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-dm-10 col-md-8 col-lg-6 ">
            <!-- /.box -->
            <div class="box">
                <section class="content-header">
                    <h1 class=" col-xs-12 text-center">
                        <strong class="text-uppercase">Contato</strong> - <em>
                            <?php
                            if (isset($title)) echo $title;
                            else echo "Todos";
                            ?>
                        </em>
                    </h1>
                </section>
                <hr class="" />
                <!-- /.box -->
                <div class="box-body">
                    <?php if ($msg = get_msg()) echo $msg; ?>
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <?php
                                    $setup = array(
                                        'class' => 'form-control',
                                        'trim|required'
                                    );

                                    if ($msg = get_msg()) echo $msg;

                                    echo form_open_multipart();
                                    ?>
                                    <h2 id="redessociais" class=" col-xs-12 text-left" style="margin-top:0; padding-top:0">
                                        Informações
                                    </h2>
                                    <?php
                                    // FORM ADD NEW
                                    $email = isset($contact['email']) ? $contact['email'] : "";
                                    echo ' <div class="col-xs-12 form-group">';
                                    $opts = array('name' => 'email', 'value' => $email, 'title' => 'Informe o email para contato');
                                    echo form_label('Email para contato:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $telefone = isset($contact['telefone']) ? $contact['telefone'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'telefone', 'value' => $telefone, 'title' => 'Telefone');
                                    echo form_label('Telefone:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $ramal = isset($contact['ramal']) ? $contact['ramal'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'ramal', 'value' => $ramal, 'title' => 'Ramal');
                                    echo form_label('Ramal:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $whatsapp = isset($contact['whatsapp']) ? $contact['whatsapp'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'whatsapp', 'value' => $whatsapp, 'title' => 'Whatsapp');
                                    echo form_label('<i class="fa fa-whatsapp"></i> - Whatsapp:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    ?>
                                    <h2 id="redessociais" class=" col-xs-12 text-left">
                                        Redes Sociais
                                    </h2>
                                    <?php

                                    $facebook = isset($contact['facebook']) ? $contact['facebook'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'facebook', 'value' => $facebook, 'title' => 'Facebook');
                                    echo form_label('<i class="fa fa-facebook"></i> - Facebook:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $instagram = isset($contact['instagram']) ? $contact['instagram'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'instagram', 'value' => $instagram, 'title' => 'Instagram');
                                    echo form_label('<i class="fa fa-instagram"></i> - Instagram:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $twitter = isset($contact['twitter']) ? $contact['twitter'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'twitter', 'value' => $twitter, 'title' => 'Twitter');
                                    echo form_label('<i class="fa fa-twitter"></i> - Twitter:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $youtube = isset($contact['youtube']) ? $contact['youtube'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'youtube', 'value' => $youtube, 'title' => 'Youtube');
                                    echo form_label('<i class="fa fa-youtube"></i> - Youtube:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $linkedin = isset($contact['linkedin']) ? $contact['linkedin'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'linkedin', 'value' => $linkedin, 'title' => 'Linkedin');
                                    echo form_label('<i class="fa fa-linkedin"></i> - Linkedin:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';

                                    $behance = isset($contact['behance']) ? $contact['behance'] : "";
                                    echo ' <div class="col-xs-6 form-group">';
                                    $opts = array('name' => 'behance', 'value' => $behance, 'title' => 'Behance');
                                    echo form_label('<i class="fa fa-behance"></i> - Behance:');
                                    echo form_input($opts, '', $setup);
                                    echo '</div>';


                                    ?>
                                    <h2 class=" col-xs-12 text-left">
                                        Endereço
                                    </h2>
                                    <?php

                                    $endereco = isset($contact['endereco']) ? $contact['endereco'] : "";
                                    echo ' <div class="col-xs-12 form-group">';
                                    echo form_label('Endereço completo:');
                                    $opts = array(
                                        'name'        => 'endereco',
                                        // 'id'          => 'vc_desc',
                                        'value'       => $endereco,
                                        'rows'        => '5',
                                        'cols'        => '10',
                                        'style'       => 'width:100%',
                                        'class'       => 'form-control',
                                        'title' => 'Endereço'
                                    );
                                    echo form_textarea($opts);
                                    echo '</div>';


                                    ?>
                                    <h2 id="googlemapsarea" class=" col-xs-12 text-left">
                                        Google Maps
                                    </h2>
                                    <?php

                                    $google_maps = isset($contact['google_maps']) ? $contact['google_maps'] : "";
                                    echo ' <div class="col-xs-12 form-group">';
                                    echo form_label('Embed Code [HTML]:');
                                    $opts = array(
                                        'name'        => 'google_maps',
                                        // 'id'          => 'vc_desc',
                                        'value'       => $google_maps,
                                        'rows'        => '5',
                                        'cols'        => '10',
                                        'style'       => 'width:100%',
                                        'class'       => 'form-control',
                                        'title' => 'Google Maps [HTML]'
                                    );
                                    echo form_textarea($opts);
                                    echo '</div>';

                                    // ====== Submit
                                    echo '<div class="col-xs-12">';
                                    echo form_submit(
                                        'enviar',
                                        'Salvar',
                                        array('class' => 'btn btn-success pull-right')
                                    );
                                    echo '</div>';
                                    // Form Closed
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Wrap -->
                </div>
            </div>
        </div>
    </div>
</section>
</div>


<script>
    var $hora = ['22', '00', '00'];
    var $url = 'txDHMarcacao=' + $hora[0] + '%3A' + $hora[1] + '%3A' + $hora[2] + '&txHour=' + $hora[0] + '&txMinute=' + $hora[1] + '&txSeconds=' + $hora[2] + '&txLatitude=0.0&txLongitude=0.0&cboLocal=3022;';
</script>