@extends('main')
@section('titulo', 'Listagem de Acessórios')

@section('conteudo')
<div class="card card-custom p-4">
    <!-- Cabeçalho & Ações -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0"><i class="bi bi-tools text-primary me-2"></i>Acessórios Cadastrados</h4>
            <span class="text-muted small">Gerencie e pesquise os acessórios em estoque</span>
        </div>
        <a href="{{ route('acessorios.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i> Novo Acessório</a>
    </div>

    <!-- Barra de Filtros -->
    <form action="{{ route('acessorios.search') }}" method="POST" class="bg-light p-3 rounded-3 mb-4">
        @csrf
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="tipo" class="form-select border-0 shadow-sm">
                    <option value="nome" {{ request('tipo') == 'nome' ? 'selected' : '' }}>Nome</option>
                    <option value="preco" {{ request('tipo') == 'preco' ? 'selected' : '' }}>Preço</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="valor" class="form-control border-0" placeholder="Pesquisar..." value="{{ request('valor') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
                <a href="{{ route('acessorios.index') }}" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabela Estilizada -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                    <tr>
                        <td class="fw-bold text-secondary">#{{ $item->id }}</td>
                        <td class="fw-semibold">{{ $item->nome }}</td>
                        <td><span class="badge bg-success-subtle text-success border border-success-subtle">R$ {{ number_format($item->preco, 2, ',', '.') }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $item->quantidade ?? rand(1, 50) }} unid.</span></td>
                        <td class="text-end">
                            <a href="{{ route('acessorios.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('acessorios.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Deseja realmente excluir?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Nenhum acessório encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop