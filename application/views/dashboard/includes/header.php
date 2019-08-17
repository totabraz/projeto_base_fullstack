<header role="banner">
    <nav class="navbar navbar-dark bg-dark navbar-expand-md">
        <div class="container">
            <?php  
            ?>
            <a class="nav-link navbar-brand" href="<?php echo base_url(); ?>">Site do evento</a>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsing-navbar" aria-controls="collapsing-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse justify-content-between collapse" id="collapsing-navbar">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url('dashboard/home'); ?>" aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item"><a href="<?php echo base_url('dashboard/perfil'); ?>" class="nav-link">Meu Dados</a></li>
                    <li class="dropdown">
                        <a class="nav-link bnav-item dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inscrições</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li class="nav-item"><a class="dropdown-item" href="<?php echo base_url('dashboard/evento'); ?>">No Evento</a></li>
                            <li class="nav-item"><a class="dropdown-item" href="<?php echo base_url('dashboard/minicursos'); ?>">Em Minicuros</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('dashboard/artigo'); ?>">Submeter Artigos</a></li>
                    <?php  
                    ?>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo base_url('logout'); ?>" class="nav-link">
                            Sair
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header> 