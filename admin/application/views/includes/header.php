<div class="ls-topbar">

    <!-- Barra de Notificações -->
    <div class="ls-notification-topbar">

        <!-- Links de apoio -->
        <!--<div class="ls-alerts-list">
            <a href="#" class="ls-ico-bell-o" data-counter="8" data-ls-module="topbarCurtain" data-target="#ls-notification-curtain"><span>Notificações</span></a>
            <a href="#" class="ls-ico-bullhorn" data-ls-module="topbarCurtain" data-target="#ls-help-curtain"><span>Ajuda</span></a>
            <a href="#" class="ls-ico-question" data-ls-module="topbarCurtain" data-target="#ls-feedback-curtain"><span>Sugestões</span></a>
        </div>-->

        <!-- Dropdown com detalhes da conta de usuário -->
        <div data-ls-module="dropdown" class="ls-dropdown ls-user-account">
            <a href="#" class="ls-ico-user">
                <!--<img src="/locawebstyle/assets/images/locastyle/avatar-example.jpg" alt="" />-->
                <span class="ls-name"><?= $this->session->admin->nome ?></span>
            </a>

            <nav class="ls-dropdown-nav ls-user-menu">
                <ul>
                    <!--<li><a href="<?= site_url('perfil'); ?>">Meus dados</a></li>-->
                    <li><a href="<?= site_url('login/logout'); ?>">Sair</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <span class="ls-show-sidebar ls-ico-menu"></span>

    <a href="{voltar}"  class="ls-go-next"><span class="ls-text">Voltar</span></a>

    <!-- Nome do produto/marca com sidebar -->
    <h1 class="ls-brand-name">
        <a href="home" class="ls-ico-earth">
        <small>Dashboard</small>
        cursosdeespanholonline.com
        </a>
    </h1>

    <!-- Nome do produto/marca sem sidebar quando for o pre-painel  -->
</div>