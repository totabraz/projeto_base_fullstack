<?php
$login = "";
$email = "";
$name = "";
$permission_name = "";
$permission = 0;


if (isset($this->session->userdata)) {
    $user = $this->session->userdata;
    $login = $user['login'];
    $email = $user['email'];
    $name = $user['name'];
    if (explode(' ', $user['name'])) {
        $name = array_slice(explode(' ', $name), 0, 2);
        $name = implode(" ", $name);
    }
    $permission_name = $user['permission_name'];
    $permission_value = $user['permission_value'];
} else {
    header("location: " . base_url() . "admin/login");
}
$menuActiveSplited = '';
if (isset($menuActive)) {
    $menuActiveSplited = explode("/", $menuActive);
} else {
    $menuActive = ' ';
}

$display = 'block';

if (!isset($permission_value)) $permission_value = 2;

switch ($permission_value) {
    case PERMISSION_ROOT:
        $nav_news  = false;
        $nav_blog = true;
        $nav_users = false;
        $nav_mysettings = true;
        $nav_documents = false;
        $nav_categories = false;
        $nav_page_contatct = true;
        $nav_analytics = true;
        $nav_ads = true;
        break;

    case PERMISSION_ADMIN:
        $nav_news  = false;
        $nav_blog = false;
        $nav_users = false;
        $nav_mysettings = false;
        $nav_documents = false;
        $nav_categories = false;
        $nav_page_contatct = false;
        $nav_analytics = false;
        $nav_ads = false;
        break;

    default:
        $nav_news  = false;
        $nav_blog = false;
        $nav_users = false;
        $nav_mysettings = false;
        $nav_documents = false;
        $nav_categories = false;
        $nav_page_contatct = false;
        $nav_analytics = false;
        $nav_ads = false;
        break;
}



?>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo base_url('dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo  $name ?></p>
                    <p><small><i class="fa fa-circle text-success"></i>&nbsp;<?php echo $login . ' / ' . $permission_name; ?></small></p>
                </div>
            </div>


            <ul class="sidebar-menu">
                <li class="header">CATEGORIAS </li>
            </ul>

            <!-- MENU CATEGORIES -->
            <?php if ($nav_categories) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-users"></i>&nbsp;<span>Categorias</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'docs') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/documents/cadastrar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'documents/create') echo " "; ?>-o"></i>&nbsp;Cadastrar</a></li>
                            <li><a href="<?php echo base_url('admin/documents/listar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'documents/list') echo " "; ?>-o"></i>&nbsp;Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>



            <ul class="sidebar-menu">
                <li class="header">POSTAGENS</li>
            </ul>

            <!-- MENU NOTÍCIAS -->
            <?php if ($nav_news) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-inbox"></i>&nbsp;<span>[OK v2] Notícias</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'news') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/news/cadastrar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'news/create') echo " "; ?>-o"></i>&nbsp;Nova Notícia</a></li>
                            <li><a href="<?php echo base_url('admin/news/listar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'news/list') echo " "; ?>-o"></i>&nbsp;Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>

            <!-- MENU BLOG -->
            <?php if ($nav_blog) { ?>
                <ul class="sidebar-menu" data-widget="tree">

                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-rss"></i>&nbsp;<span>Blog OKKKK</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'blog') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/blog/cadastrar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'blog/create') echo " "; ?>-o"></i>&nbsp;Nova Postagem</a></li>
                            <li><a href="<?php echo base_url('admin/blog/listar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'blog/list') echo " "; ?>-o"></i>&nbsp;Listar Postagens</a></li>
                            <li><a href="<?php echo base_url('admin/blog/categorias'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'blog/categorias') echo " "; ?>-o"></i>&nbsp;Categorias</a></li>
                            <li><a href="<?php echo base_url('admin/blog/cidades'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'blog/cidades') echo " "; ?>-o"></i>&nbsp;Cidades</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>




            <ul class="sidebar-menu">
                <li class="header">DOCUMENTOS</li>
            </ul>


            <!-- MENU DOCS -->
            <?php if ($nav_documents) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-users"></i>&nbsp;<span>Documentos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'docs') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/docs/cadastrar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'docs/create') echo " "; ?>-o"></i>&nbsp;Cadastrar</a></li>
                            <li><a href="<?php echo base_url('admin/docs/listar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'docs/list') echo " "; ?>-o"></i>&nbsp;Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>





            <ul class="sidebar-menu">
                <li class="header">MENU ADMIN</li>
            </ul>

            <!-- MENU USERS -->
            <?php if ($nav_users) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-users"></i>&nbsp;<span>Usuários OKKKK</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'users') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/users/cadastrar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'users/create') echo " "; ?>-o"></i>&nbsp;Cadastrar</a></li>
                            <li><a href="<?php echo base_url('admin/users/listar'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'users/list') echo " "; ?>-o"></i>&nbsp;Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>













            <ul class="sidebar-menu">
                <li class="header">CONFIGURAÇÕES DO SITE</li>
            </ul>

            <!-- MENU SOCIAL -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="treeview menu-open">
                    <a href="#">
                        <i class="fa fa-address-card-o"></i>&nbsp;<span>[OK v2] Área de Contato</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <?php
                    $display = ($menuActiveSplited == 'config') ? 'block' : 'block';

                    ?>
                    <ul class="treeview-menu " style="display:<?php echo $display ?>">
                        <li><a href="<?php echo base_url('admin/site/config/contato'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'site/contato') echo " "; ?>-o"></i>&nbsp;Contato</a></li>
                        <li><a href="<?php echo base_url('admin/site/config/redessociais'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'site/redessociais') echo " "; ?>-o"></i>&nbsp;Redes Sociais</a></li>
                        <li><a href="<?php echo base_url('admin/site/config/endereco'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'site/endereco') echo " "; ?>-o"></i>&nbsp;Endereço</a></li>
                        <li><a href="<?php echo base_url('admin/site/config/googlemaps'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'site/googlemaps') echo " "; ?>-o"></i>&nbsp;Google Maps</a></li>
                    </ul>
                </li>

            </ul>


            <!-- MENU Analytics -->
            <?php if ($nav_users) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-line-chart"></i>&nbsp;<span>[OK v2] Google Analytics</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'users') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/site/config/analytics'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'admin/analytics') echo " "; ?>-o"></i>&nbsp;Editar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>

            <!-- MENU Ads -->
            <?php if ($nav_users) { ?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-line-chart"></i>&nbsp;<span>[OK v2] Propagandas</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <?php $display = ($menuActiveSplited == 'users') ? 'block' : 'block'; ?>
                        <ul class="treeview-menu " style="display:<?php echo $display ?>">
                            <li><a href="<?php echo base_url('admin/site/config/ads'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'admin/ads') echo " "; ?>-o"></i>&nbsp;Editar Ads</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>

            <!-- MENU My SETTINGS -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="treeview menu-open">
                    <a href="#">
                        <i class="fa fa-cog"></i>&nbsp;<span>[OK v2] Meu Perfil</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <?php $display = ($menuActiveSplited == 'config') ? 'block' : 'block'; ?>
                    <ul class="treeview-menu " style="display:<?php echo $display ?>">
                        <li><a href="<?php echo base_url('admin/users/meuperfil'); ?>"><i class="fa fa-circle<?php if ($menuActive == 'users/myprofile') echo " "; ?>-o"></i>&nbsp;Editar</a></li>
                    </ul>
                </li>
            </ul>

        </section>
        <!-- /.sidebar -->
    </aside>