<header class="header-global">
    <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg navbar-theme-primary headroom navbar-light navbar-transparent navbar-theme-primary">
        <div class="container position-relative">
            <a class="navbar-brand shadow-soft py-2 px-3 rounded border border-light mr-lg-4" href="/">
                <img class="navbar-brand-dark" src="<?=$configWeb->config_web_logo_light_url?>" alt="Logo light">
                <img class="navbar-brand-light" src="<?=$configWeb->config_web_logo_light_url?>" alt="Logo dark">
            </a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/" class="navbar-brand shadow-soft py-2 px-3 rounded border border-light">
                                <img src="<?=$configWeb->config_web_logo_light_url?>" alt="Themesberg logo">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" class="bi bi-x-lg" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" title="close" aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <?php include 'load/menu.php'?>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <?php if ($auth===false): ?>
                <a href="/auth" class="btn btn-primary"><i class="bi bi-box-arrow-right"></i> Login</a>
                <?php else: ?>
                <a href="javascript:;" class="btn btn-primary" onclick="logout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
                <?php endif ?>
                <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            </div>
        </div>
    </nav>
</header>