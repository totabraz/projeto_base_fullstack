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
                        <strong class="text-uppercase">Blog</strong> - <em>
                            <?php
                            if (isset($title)) echo $title;
                            else echo "Cidades";
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
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php
                                                $setup = array(
                                                    'class' => 'form-control',
                                                    'trim|required'
                                                );
                                                if ($msg = get_msg()) {
                                                    echo $msg;
                                                }
                                                echo form_open_multipart();
                                                $blog_cidade = isset($blog_cidade) ? $blog_cidade : "";

                                                // FORM ADD NEW
                                                echo ' <div class=" col-xs-12">';
                                                echo form_label('Cidades:');
                                                echo ' </div>';
                                                
                                                echo ' <div class="form-group col-xs-9 col-sm-10">';
                                                $opts = array(
                                                    'name'        => 'blog_cidade',
                                                    // 'id'          => 'vc_desc',
                                                    'value'       => $blog_cidade,
                                                    'rows'        => '10',
                                                    'cols'        => '10',
                                                    'style'       => 'width:100%',
                                                    'class'       => 'form-control',
                                                    'title' => 'Blog cidade'
                                                );
                                                echo form_input($opts);
                                                echo '</div>';

                                                // ====== Add other
                                                echo ' <div class="form-group col-xs-3 col-sm-2">';
                                                    echo ' <div class="row">';
                                                    echo form_submit(
                                                        'enviar',
                                                        'Adicionar',
                                                        array('class' => 'btn btn-success pull-right  text-right col-xs-12')
                                                    );
                                                    echo '</div>';
                                                echo '</div>';
                                                // Form Closed
                                                echo form_close();
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                     
    </div>
    </div>
    <div class="row">


        <div class="col-xs-12 col-dm-10 col-md-8 col-lg-6 ">
            <!-- /.box -->
            <div class="box">
                <section class="content-header">
                    <h1 class=" col-xs-12 text-center">
                        <strong class="text-uppercase">Cidades</strong> - <em>Listagem</em>
                    </h1>
                </section>
                <hr />
                <!-- /.box-header -->

                <div class=" box-body">
                    <?php
                    if (isset($blog_cidades) && sizeof($blog_cidades) > 0) { ?>

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>cidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blog_cidades as $single_blog) { 
                                    ?>
                                    <tr>
                                        <td class="col-xs-12">
                                            <?php if (isset($single_blog->blog_cidade)) echo $single_blog->blog_cidade; ?>

                                        </td>
                                        <td>
                                            <a href="<?php echo base_url('admin/blog/cidades/' . $single_blog->ID) ?>" class="btn btn-small btn-danger" title="Excluir">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <tfoot>
                                <tr>
                                    <th>cidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    <?php } else { ?>
                        <p>Nenhuma cidade cadastrada</p>
                    <?php }  ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
</div>


<script>
    var $hora = ['22', '00', '00'];
    var $url = 'txDHMarcacao=' + $hora[0] + '%3A' + $hora[1] + '%3A' + $hora[2] + '&txHour=' + $hora[0] + '&txMinute=' + $hora[1] + '&txSeconds=' + $hora[2] + '&txLatitude=0.0&txLongitude=0.0&cboLocal=3022;';
</script>