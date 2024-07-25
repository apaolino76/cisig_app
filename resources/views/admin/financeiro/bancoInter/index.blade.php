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
                <div class="col-12 d-flex flex-column flex-md-row">
                    <a href="#" class="btn btn-info text-white mb-1 mb-md-0 mr-md-1" tabindex="-1" role="button" aria-disabled="true">
                        <i class="fa fa-download fa-fw fa-md mr-1"></i>Baixar
                    </a>
                    <a href="#" class="btn btn-info text-white mb-1 mb-md-0 mr-md-1" tabindex="-1" role="button" aria-disabled="true">
                        <i class="fa fa-upload fa-fw fa-md mr-1"></i>Gerar
                    </a>
                    <a href="#" class="btn btn-info text-white" tabindex="-1" role="button" aria-disabled="true">
                        <i class="fa fa-circle-xmark fa-fw fa-md mr-1"></i>Cancelar
                    </a>
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
                                                    <button type="button" class="btn btn-primary text-right mb-1">
                                                        Valor <span class="badge bg-secondary">{{ 'R$ '. number_format($pagamento["valor"], 2, ",", ".") }}</span>
                                                    </button>
                                                    <button type="button" class="btn btn-primary text-right">
                                                        Quant. <span class="badge bg-secondary">{{ $pagamento["quantidade"] }}</span>
                                                    </button>
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
