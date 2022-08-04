@extends('default')
@section('title', 'Produtos')

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
        <h1 class="my-5 text-center"> Produtos</h1>
        <div class="d-flex justify-content-end">
            <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary mb-3">Adicionar Produto</button>
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar um Produto
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('create.enterprise') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nameEnterprise" class="form-label">SKU</label>
                                    <input type="text" name="name" class="form-control" id="nameEnterprise" required
                                        placeholder="Insira um nome">
                                </div>
                                <div class="mb-3">
                                    <label for="nameEnterprise" class="form-label">Quantidade</label>
                                    <input type="number" name="quantity" class="form-control" id="nameEnterprise" required
                                        placeholder="Insira um nome">
                                </div>
                                <div class="mb-3">
                                    <label for="nameEnterprise" class="form-label">Preço</label>
                                    <input type="number" name="cost" class="form-control" id="nameEnterprise" required
                                        placeholder="Insira um nome">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (count($products) == 0)
            <div class="card">
                <div class="card-body">
                    <h2>Você não possui nenhum produto registrado</h2>
                </div>
            </div>
        @elseif(count($products) != 0)
            @foreach ($products as $count => $product)
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h2>
                                    {{ $product['sku'] }}
                                </h2>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    Quantidade: {{ $product['quantity'] }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    Preço: {{ $product['cost'] }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    Custo Total: {{ $product['total_cost'] }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p><b>Empresa:</b> {{ $product['enterprise']->name }}</p>
                            <div class="d-flex">
                                <button class="btn btn-primary me-2">Adicionar Quantidade</button>
                                <button class="btn btn-warning me-2">Produtos em Devolução</button>
                                <button class="btn btn-danger">Produtos Danificados</button>
                            </div>
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
