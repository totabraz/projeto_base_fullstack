<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- Content Header (Page header) -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php

$blog_date_published = changeDateFromDB(isset($blog['blog_date_published']) ? $blog['blog_date_published'] : date('d-m-Y'));

?>

<script>
    $(document).ready(function() {
        $(function() {
            $("#datepicker").datepicker();
            $('#datepicker').datepicker("option", "dateFormat", 'dd-mm-yy');
            $("#datepicker").datepicker('setDate', <?php echo changeDateFromDB($blog_date_published) ?>);
        });
    });
</script>

<style>
    .ui-widget-content.ui-helper-clearfix.ui-corner-all {
        z-index: 8010 !important;
    }
</style>

<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-dm-10 col-md-8 col-lg-6 ">
            <!-- /.box -->
            <div class="box">
                <section class="content-header">
                    <h1 class=" col-xs-12 text-center">
                        <strong class="text-uppercase">Blog</strong> - <em>
                            <?php
                            if (isset($title)) echo $title;
                            else echo "Nova/Editar Notícia";
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

                                <?php
                                $setup = array(
                                    'class' => 'form-control',
                                    'trim|required'
                                );
                                if ($msg = get_msg()) {
                                    echo $msg;
                                }
                                echo form_open_multipart();
                                $blog_title = isset($blog['blog_title']) ? $blog['blog_title'] : "";
                                $blog_categoria = isset($blog['blog_categoria']) ? $blog['blog_categoria'] : 'sem_categoria';
                                $blog_cidade = isset($blog['blog_cidade']) ? $blog['blog_cidade'] : 'todas_cidades';
                                $blog_body = isset($blog['blog_body']) ? $blog['blog_body'] : "";
                                $blog_img = isset($blog['blog_img']) ? $blog['blog_img'] : "";
                                $blog_published = isset($blog['blog_published']) ? $blog['blog_published'] : "";
                                $blog_date_to_publish = isset($blog['blog_date_to_publish']) ? $blog['blog_date_to_publish'] : 00 - 00 - 0000;
                                $blog_author_name = (isset($this->session->get_userdata()['name'])) ? $this->session->get_userdata()['name'] : '';
                                $blog_author_login = (isset($this->session->get_userdata()['login'])) ? $this->session->get_userdata()['login'] : '';
                                // FORM ADD NEW
                                ?>

                                <div class="form-group">
                                    <?php

                                    $opts = array('name' => 'blog_title', 'value' => $blog_title, 'title' => 'Infome o título');
                                    echo form_label('Título:');
                                    echo form_input($opts, '', $setup);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $opts = array('name' => 'blog_date_to_publish', 'id' => 'datepicker', 'value' => $blog_date_to_publish, 'title' => 'Infome a data a ser publicada');
                                    echo form_label('Data para publicação:');
                                    echo form_input($opts, '', $setup);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php

                                    $opts = array('name' => 'blog_author_name', 'value' => $blog_author_name, 'title' => 'Autor', 'readonly' => 'readonly');
                                    echo form_label('Autor Name:');
                                    echo form_input($opts, '', $setup);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $opts = array('name' => 'blog_author_login', 'value' => $blog_author_login, 'title' => 'Autor', 'readonly' => 'readonly');
                                    echo form_label('Autor Login:');
                                    echo form_input($opts, '', $setup);
                                    ?>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 form-group">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php echo form_label('Categorias:'); ?>
                                            </div>
                                            <div class="col-xs-12">
                                                <?php
                                                $arrayOpts["sem_categoria"] = 'Sem Categoria';
                                                if (isset($blog_categorias)) {
                                                    for ($i = 0; $i < sizeof($blog_categorias); $i++) {
                                                        $arrayOpts[$blog_categorias[$i]->blog_categoria_id] = $blog_categorias[$i]->blog_categoria;
                                                    }
                                                }
                                                $opts = array(
                                                    'autocomplete' => 'off',
                                                    'name' => 'blog_categoria',
                                                    'value' => $blog_categoria, 'title' => 'Categoria da postagem',
                                                    'class' => 'form-control editorhtml col'
                                                );
                                                echo form_dropdown($opts, $arrayOpts,$blog_categoria);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 form-group">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php echo form_label('Cidades:'); ?>
                                            </div>
                                            <div class="col-xs-12">
                                                <?php
                                                $arrayOptsCidades["todas_cidades"] = 'Todas as Cidades';
                                                if (isset($blog_cidades)) {
                                                    for ($i = 0; $i < sizeof($blog_cidades); $i++) {
                                                        $arrayOptsCidades[$blog_cidades[$i]->blog_cidade_id] = $blog_cidades[$i]->blog_cidade;
                                                    }
                                                }
                                                $blog_cidade = (isset($blog_cidade))? $blog_cidade : " ";
                                                $opts = array(
                                                    'autocomplete' => 'off',
                                                    'name' => 'blog_cidade',
                                                    'value' => $blog_cidade, 'title' => 'Fitro de Cidade',
                                                    'class' => 'form-control editorhtml col'
                                                );
                                                echo form_dropdown($opts, $arrayOptsCidades,$blog_cidade);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <?php
                                    echo form_label('Postagem:');
                                    $opts = array(
                                        'name'        => 'blog_body',
                                        // 'id'          => 'vc_desc',
                                        'value'       => $blog_body,
                                        'rows'        => '10',
                                        'cols'        => '10',
                                        'style'       => 'width:100%',
                                        'class'       => 'form-control',
                                        'title' => 'Postagem'
                                    );
                                    echo form_textarea($opts);
                                    ?>
                                </div>

                                <?php // === Add File  
                                ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <label class="custom-file-label" for="imgFormInput">Anexar Imagem:</label>
                                                    <input id="imgFormInput" type="file" name="blog_img" size="20">

                                                </div>
                                            </div>
                                        </div>

                                        <?php if (isset($blog_img) && $blog_img != '') { ?>
                                            <figure class="col-xs-12 col-sm-6 col-md-3">
                                                <img src="<?php echo base_url('uploads/') . $blog_img; ?>" style="width:100px; height:100px;" />
                                            </figure>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php
                                // ====== Habilitar/Desabilitar
                                ?>
                                <div class="col-xs-12 col-sm-6 form-group">
                                    <div class="row">
                                        <?php
                                        echo form_label('Publicada:');
                                        $arrayOpts = array(
                                            "1" => "Sim",
                                            "0" => "Não",
                                        );
                                        $opts = array(
                                            'autocomplete' => 'off',
                                            'name' => 'blog_published',
                                            'value' => $blog_published, 'title' => 'Essa notícia está publicada?',
                                            'class' => 'form-control editorhtml col'
                                        );

                                        echo form_dropdown($opts, $arrayOpts,$blog_published);
                                        ?>
                                    </div>
                                </div>

                                <?php // ====== Add other 
                                ?>

                                <div class="row">
                                    <div class="pull-rihgt text-right col-xs-12">
                                        <?php
                                        echo form_submit(
                                            'enviar',
                                            'Salvar',
                                            array('class' => 'btn btn-success pull-right')
                                        );
                                        ?>
                                    </div>
                                </div>

                                <?php
                                // Form Closed
                                echo form_close();
                                ?>
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