@extends('layouts.app')

@section('title', 'Configurações')

@section('page-title', 'Configurações do Sistema')

@section('content')
<div class="container mt-4">
    <h3>Opções de Configuração</h3>
    <form id="config-form">
        <!-- Configuração de Armazenamento -->
        <div class="mb-4">
            <h5>Armazenamento</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="storage" id="storageRedis" value="redis">
                <label class="form-check-label" for="storageRedis">
                    Redis
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="storage" id="storageMySQL" value="mysql">
                <label class="form-check-label" for="storageMySQL">
                    MySQL
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="storage" id="storageNone" value="none" checked>
                <label class="form-check-label" for="storageNone">
                    Nenhum
                </label>
            </div>
        </div>

        <!-- Outras Configurações -->
        <div class="mb-4">
            <h5>Outras Configurações</h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableLogging" name="enableLogging">
                <label class="form-check-label" for="enableLogging">
                    Ativar Logging
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableCache" name="enableCache">
                <label class="form-check-label" for="enableCache">
                    Ativar Cache
                </label>
            </div>
        </div>

        <!-- Botão de Salvar -->
        <button type="button" class="btn btn-primary" id="saveConfig">Salvar Configurações</button>
    </form>
</div>
@endsection
<script src=<?php echo asset('js/jquery.js'); ?>></script>
@section('scripts')
<script>
    $(document).ready(function () {
        // Carregar configurações atuais ao carregar a página
        $.ajax({
            url: '/configurations',
            method: 'GET',
            success: function (config) {
                if (config.storage) {
                    $(`#storage${config.storage.charAt(0).toUpperCase() + config.storage.slice(1)}`).prop('checked', true);
                }
                $('#enableLogging').prop('checked', config.enable_logging === 1);
                $('#enableCache').prop('checked', config.enable_cache === 1);
            },
            error: function () {
                alert('Erro ao carregar configurações.');
            }
        });

        // Salvar configurações ao clicar no botão
        $('#saveConfig').click(function () {
     
            const configData = {
                storage: $('input[name="storage"]:checked').val(),
                enable_logging: $('#enableLogging').is(':checked') ? 1 : 0,
                enable_cache: $('#enableCache').is(':checked') ? 1 : 0,
            };

            $.ajax({
                url: '/configurations',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(configData),
                success: function () {
                    alert('Configurações salvas com sucesso.');
                },
                error: function () {
                    alert('Erro ao salvar configurações.');
                }
            });
        });
    });
</script>
@endsection
