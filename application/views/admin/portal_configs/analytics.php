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
                        <strong class="text-uppercase">Config. do Portal</strong> - <em>
                            <?php
                            if (isset($title)) echo $title;
                            else echo "Google Maps";
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
                                $google_analytics = isset($google_analytics) ? $google_analytics : "";

                                // FORM ADD NEW
                                echo ' <div class="form-group">';
                                echo form_label('Google Maps [embed code]:');

                                $opts = array(
                                    'name'        => 'google_analytics',
                                    // 'id'          => 'vc_desc',
                                    'value'       => $google_analytics,
                                    'rows'        => '10',
                                    'cols'        => '10',
                                    'style'       => 'width:100%',
                                    'class'       => 'form-control',
                                    'title' => 'Google Maps [embed code]'
                                );
                                echo form_textarea($opts);
                                echo '</div>';


                                // ====== Add other

                                echo '<div class="row">';
                                echo '<div class="pull-rihgt text-right col-xs-12">';
                                echo form_submit(
                                    'enviar',
                                    'Salvar',
                                    array('class' => 'btn btn-success pull-right')
                                );
                                echo '</div>';
                                echo '</div>';
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


<script>
    var $hora = ['22', '00', '00'];
    var $url = 'txDHMarcacao=' + $hora[0] + '%3A' + $hora[1] + '%3A' + $hora[2] + '&txHour=' + $hora[0] + '&txMinute=' + $hora[1] + '&txSeconds=' + $hora[2] + '&txLatitude=0.0&txLongitude=0.0&cboLocal=3022;';
</script>