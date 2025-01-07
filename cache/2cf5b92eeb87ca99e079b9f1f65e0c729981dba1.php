<div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginRegisterModalLabel">Acessar ou Registrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Abas para Login e Registro -->
                <ul class="nav nav-tabs" id="loginRegisterTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab" aria-controls="login-pane" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab" aria-controls="register-pane" aria-selected="false">Registrar</button>
                    </li>
                </ul>

                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="loginRegisterTabsContent">
                    <!-- Aba de Login -->
                    <div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab">
                        <form id="login-form">
                            <div class="mb-3">
                                <label for="login-email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="login-email" placeholder="Digite seu e-mail">
                            </div>
                            <div class="mb-3">
                                <label for="login-password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="login-password" placeholder="Digite sua senha">
                            </div>
                            <button type="button" id="login-button" class="btn btn-primary">Entrar</button>
                        </form>
                    </div>

                    <!-- Aba de Registro -->
                    <div class="tab-pane fade" id="register-pane" role="tabpanel" aria-labelledby="register-tab">
                        <form id="register-form">
                            <div class="mb-3">
                                <label for="register-name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="register-name" placeholder="Digite seu nome completo">
                            </div>
                            <div class="mb-3">
                                <label for="register-email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="register-email" placeholder="Digite seu e-mail">
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="register-password" placeholder="Digite sua senha">
                            </div>
                            <button type="button" id="register-button" class="btn btn-success">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\teste_gitclone\teste_apistar\src\Views/partials/login-modal.blade.php ENDPATH**/ ?>