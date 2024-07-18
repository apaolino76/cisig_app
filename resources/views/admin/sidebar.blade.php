<div class="col-md-2 mb-2 mb-md-0">
    <div class="card">
        <div class="card-header d-flex flex-row justify-content-between align-items-center p-2">
            <div class="nav-link">
                <i class="fa fa-signs-post fa-fw fa-md" aria-hidden="true"></i> Menu
            </div>
            <button class="navbar-toggler custom-toggler-black" type="button" data-toggle="collapse" data-target="#colp"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="card-body d-inline-blocks p-2">
            <div class="collapse show pl-0" id="sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link pb-0 pl-0" href="{{ route('admin.home') }}">
                            <i class="fa fa-house-chimney fa-fw fa-md" aria-hidden="true"></i> {{ __('Home') }} 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed pb-0 pl-0" href="#menuFinanceiro" data-toggle="collapse" data-target="#menuFinanceiro">
                            <i class="fa fa-coins fa-fw fa-md" aria-hidden="true"></i> {{ __('Finance') }}
                        </a>
                        <div class="collapse" id="menuFinanceiro" aria-expanded="false">
                            <ul class="nav flex-column pl-2">
                                <li class="nav-item">
                                    <a class="nav-link collapsed pb-0 pl-0" href="#bancoInter" data-toggle="collapse" data-target="#bancoInter">
                                        <i class="fa fa-cloud-download fa-fw fa-md" aria-hidden="true"></i> {{ __('Inter Bank') }}
                                    </a>
                                    <div class="collapse" id="bancoInter" aria-expanded="false">
                                        <ul class="nav flex-column pl-4">
                                            <li class="nav-item">
                                                <a class="nav-link pb-0 pl-0" href="{{ route('admin.financeiro.bancoInter') }}">
                                                    <i class="fa fa-window-restore fa-fw fa-md" aria-hidden="true"></i> {{ __("Access from API") }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
