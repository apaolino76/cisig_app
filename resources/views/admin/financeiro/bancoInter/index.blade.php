@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <section class="d-flex justify-content-start align-items-center" >
                <i class="fa fa-window-restore fa-fw fa-md" aria-hidden="true"></i> 
                <span class="ml-1"> {{ __('Access from API') }}</span>
            </section>
            <a class="icone-sair" href="{{ route('admin.home') }}">
                <i class="fa-solid fa-door-open fa-fw fa-md" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Sair"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-6 col-md-12 d-flex flex-column flex-md-row">
                    <button id="baixar" class="btn btn-info text-white mb-1 mb-md-0 mr-md-1">
                        <i class="fa fa-download fa-fw fa-md" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Baixar Parcelas"></i>                        
                    </button>
<!--
                    <a href="#" class="btn btn-info text-white mb-1 mb-md-0 mr-md-1" tabindex="-1" role="button" aria-disabled="true">
                        <i class="fa fa-upload fa-fw fa-md mr-1"></i>Gerar
                    </a>
                    <a href="#" class="btn btn-info text-white" tabindex="-1" role="button" aria-disabled="true">
                        <i class="fa fa-circle-xmark fa-fw fa-md mr-1"></i>Cancelar
                    </a>
-->
                    <div class="modal fade" id="processamentoModal" tabindex="-1" role="dialog" aria-labelledby="processamentoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Carregando...</span>
                                    </div>
                                    <p>Aguade! Esse processamento poderá levar alguns segundos...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-row justify-content-between align-items-center">
                            <a class="icone-sair" href="{{ route('admin.financeiro.bancoInter', ['reference' => $competenciaAnt]) }}">
                                <i class="fa fa-backward fa-fw fa-md" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Anterior"></i>
                            </a>
                            <span class="ml-1"> {{ $competenciaFrt }} </span>
                            <a class="icone-sair" href="{{ route('admin.financeiro.bancoInter', ['reference' => $competenciaPos]) }}">
                                <i class="fa fa-forward fa-fw fa-md" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Próxima"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($pagamentos as $pagamento)
                                    <div class="col-12 col-md-3 mb-2">
                                        <div class="card">
                                            <div class="card-header d-flex flex-row align-items-center">
                                                <i class="fa fa-thumbtack fa-fw fa-md" aria-hidden="true"></i>
                                                <span class="ml-1">{{ $pagamento["situacao"] }}</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex flex-column">
                                                    <div class="text-right">
                                                        <i class="fa-solid fa-people-group fa-fw fa-md" aria-hidden="true"></i>
                                                        <span>{{ $pagamento["quantidade"] }}</span>
                                                    </div>
                                                    <div class="text-right">
                                                        <i class="fa-solid fa-brazilian-real-sign fa-fw fa-md" aria-hidden="true"></i>
                                                        <span>{{ number_format($pagamento["valor"], 2, ",", ".") }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-left">
                                        <i class="fa fa-exclamation-triangle fa-fw fa-md" aria-hidden="true"></i> Não há nenhum registro de Pagamento no Banco Inter.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    $('#baixar').on('click', function() {
        // Mostrar o modal de carregamento
        $('#processamentoModal').modal('show');

        // Fazer a requisição AJAX
        $.ajax({
            url: '{{ route('admin.financeiro.bancoInter.baixar', ['reference' => $competencia]) }}',
            method: 'GET',
            data: {
                _token: '{{ csrf_token() }}' // Adicionar o token CSRF
            },
            success: function() {
                // Fechar o modal de carregamento
                $('#processamentoModal').modal('hide');
            },
            error: function() {
                // Fechar o modal de carregamento em caso de erro
                $('#processamentoModal').modal('hide');
            }
        });
    });
@endprepend
