@extends('default')
@section('title', 'Empresas Terceiras')

@section('content')
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success mt-3">
                {{ Session::get('success') }}
            </div>
        @elseif(Session::has('fail'))
            <div class="alert alert-danger mt-3">
                {{ Session::get('fail') }}
            </div>
        @endif
        <h1 class="my-5 text-center"> Empresas Terceiras</h1>
        <div class="d-flex justify-content-end">
            <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary mb-2">Adicionar Empresa</button>
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar uma Empresa
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('create.enterprise') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nameEnterprise" class="form-label">Nome</label>
                                    <input type="text" name="name" class="form-control" id="nameEnterprise" required
                                        placeholder="Insira um nome">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Adicionar Empresa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (count($enterprises) == 0)
            <div class="card">
                <div class="card-body">
                    <h2>Você não possui nenhuma empresa registrada</h2>
                </div>
            </div>
        @elseif(count($enterprises) != 0)
            @foreach ($enterprises as $count => $enterprise)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2>
                                    {{ $enterprise['name'] }}
                                </h2>
                                <p>
                                    Total de Produtos: {{ $enterprise['total'] }}<br>
                                    Custo Total: {{ $enterprise['total_cost'] }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $count }}">
                                    Editar
                                </button>
                                <a href="{{ route('delete.enterprise', [
                                    'enterprise' => $enterprise['id'],
                                ]) }}"
                                    onclick="
                                        return confirm('Tem certeza que deseja deletar esta empresa, as informações e produtos serão deletados juntos!?')
                                            "
                                    class="btn btn-danger" type="submit">
                                    Deletar
                                </a>
                            </div>
                        </div>
                        @if (count($enterprise['products']) != 0)
                            <div class="d-flex justify-content-between">
                                <h2>Produtos</h2>
                                <button class="btn btn-primary" id="products-button{{ $count }}"
                                    onclick="showHideProducts({{ $count }})">
                                    Ver Produtos
                                </button>
                            </div>
                            <div class="d-none" id="products-view{{ $count }}">
                                <table class="table">
                                    <thead>
                                        <th scope="col">#</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Custo</th>
                                        <th scope="col">Custo Total</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($enterprise['products'] as $key => $product)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>
                                                    <a href="{{ route('show.products', ['products' => $product->id]) }}">
                                                        {{ $product->sku }}
                                                    </a>
                                                </td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->cost }}</td>
                                                <td>{{ $product->total_cost }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif(count($enterprise['products']) == 0)
                            <h2 class="text-danger">Não possui nenhum produto cadastrado nesta empresa</h2>
                        @endif
                    </div>
                </div>
                <div class="modal fade" id="edit{{ $count }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Empresa {{ $enterprise['name'] }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('update.enterprise') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nameEnterprise" class="form-label">Nome</label>
                                        <input type="text" name="name" class="form-control" id="nameEnterprise"
                                            required value="{{ $enterprise['name'] }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="{{ $enterprise['id'] }}">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function showHideProducts(value) {
            let productsView = document.getElementById(`products-view${value}`);
            let productsButton = document.getElementById(`products-button${value}`);
            if (productsView.className == 'd-none') {
                productsButton.textContent = 'Esconder Produtos'
                productsView.className = 'd-block'
            } else if (productsView.className = 'd-block') {
                productsButton.textContent = 'Ver Produtos'
                productsView.className = 'd-none'
            }
        };
    </script>
@endsection
