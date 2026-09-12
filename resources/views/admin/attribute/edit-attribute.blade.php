@extends('admin.layouts.app')

@section('title')
<title>Detalhes de Atributos</title>
@endsection

@section('content')
<div class="container py-4">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Editar Detalhes do Atributo</h1>
            <p class="text-muted small mb-0">Preencha as informações do atributo.</p>
        </div>
        <div>
            <a href="{{ route('attributes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <!-- Alertas Globais -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <strong>Por favor, corrija os erros abaixo antes de salvar.</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 1º FORMULÁRIO: Edição principal do Atributo -->
    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Coluna Principal (Informações do Atributo) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-info-circle me-1"></i> Informações Gerais
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nome do Atributo -->
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">Nome do Atributo <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $attribute?->name)  }}" 
                                       placeholder="Ex: Cor" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral (Opções de Visibilidade e Status) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px; z-index: 1;">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-sliders me-1"></i> Visibilidade & Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Botões de Ação -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-floppy me-1"></i> Salvar Atributo
                            </button>
                            <button type="reset" class="btn btn-light text-muted">
                                Limpar Formulário
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- FIM DO 1º FORMULÁRIO. (Nenhum formulário está aninhado daqui pra frente) -->

    <!-- SEÇÃO DA TABELA DE OPÇÕES -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold fs-4 mb-0">Opções</h5>
                    {{-- Botão que aciona o Modal de Nova Opção --}}
                    <button type="button" class="btn btn-outline-success btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#newOptionModal" title="Novo">
                        Nova Opção
                    </button>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-center pe-3">Opção</th>
                                    <th scope="col" class="text-center pe-3">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attribute->options as $item)
                                    <tr>
                                        <td class="text-center pe-3">
                                            <strong>{{ $item->option }}</strong>
                                        </td>
                                        
                                        <td class="text-center pe-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Botão de Editar --}}
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOptionModal{{ $item->id }}" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                {{-- Formulário de Excluir --}}
                                                <form action="{{ route('attributes.destroy-option', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta opção?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- MODAL DE EDIÇÃO DE OPÇÃO (Fica dentro do laco e do TD, garantindo isolamento e acesso ao $item correto) --}}
                                            <div class="modal fade" id="editOptionModal{{ $item->id }}" tabindex="-1" aria-labelledby="editOptionModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editOptionModalLabel{{ $item->id }}">Editar Opção</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                        </div>
                                                        
                                                        <form action="{{ route('attributes.update-option', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body text-start">
                                                                <div class="mb-3">
                                                                    <label for="optionName{{ $item->id }}" class="form-label">Nome da Opção <span class="text-danger">*</span></label>
                                                                    <input 
                                                                        type="text" 
                                                                        class="form-control" 
                                                                        id="optionName{{ $item->id }}" 
                                                                        name="option"
                                                                        value="{{ old('option', $item->option) }}" 
                                                                        required
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- FIM DO MODAL DE EDIÇÃO --}}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            Nenhuma opção encontrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PARA NOVA OPÇÃO (Fica fora da tabela e de laços) --}}
    <div class="modal fade" id="newOptionModal" tabindex="-1" aria-labelledby="newOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="newOptionModalLabel">Nova Opção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                
                <form action="{{ route('attributes.store-option', $attribute->id) }}" method="POST">
                    @csrf
                    <!-- Criar nova opção geralmente é POST em vez de PUT -->
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label for="optionName" class="form-label">Nome da Opção <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="optionName" 
                                name="option"
                                value="{{ old('option') }}" 
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- FIM DO MODAL DE NOVA OPÇÃO --}}

</div>
@endsection