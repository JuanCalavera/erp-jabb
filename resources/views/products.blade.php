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
                        <form action="{{ route('create.products') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="skuProduct" class="form-label">SKU</label>
                                    <input type="text" name="sku" class="form-control" id="skuProduct" required
                                        placeholder="Insira o SKU">
                                </div>
                                <div class="mb-3">
                                    <label for="quantityProduct" class="form-label">Quantidade</label>
                                    <input type="number" name="quantity" class="form-control" id="quantityProduct" required
                                        placeholder="Quantidade em estoque">
                                </div>
                                <div class="mb-3">
                                    <label for="nameEnterprise" class="form-label">Empresa</label>
                                    <select class="form-select" required name="enterprise" id="nameEnterprise">
                                        <option selected>Empresa para este produto</option>
                                        @foreach ($enterprises as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="costProduct" class="form-label">Preço</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">R$</span>
                                        <input type="number" step="0.01" name="cost" class="form-control"
                                            id="costProduct" required>
                                    </div>
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
                <div class="card mb-3">
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
                                    Preço: R${{ number_format((float) $product['cost'], 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    Custo Total: R${{ number_format((float) $product['total_cost'], 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-md-flex justify-content-between">
                            <p><b>Empresa:</b> {{ $product['enterprise']->name }}</p>
                            <div class="d-flex">

                                <button data-bs-toggle="modal" data-bs-target="#addQuantity{{ $count }}"
                                    class="btn btn-primary me-2">Adicionar Quantidade</button>

                                <div class="modal fade" id="addQuantity{{ $count }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Adicionar quantidade do
                                                    {{ $product['sku'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('quantity.products') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="quantityAdd" class="form-label">Quantidade</label>
                                                        <input type="number" name="quantity" min="1"
                                                            class="form-control" id="quantityAdd" required
                                                            placeholder="Insira a quantidade que queira adicionar">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="action" value="add">
                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Adicionar
                                                        Produto</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button data-bs-toggle="modal" data-bs-target="#devolutionQuantity{{ $count }}"
                                    class="btn btn-warning me-2">Produtos em Devolução</button>

                                <div class="modal fade" id="devolutionQuantity{{ $count }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Devolução da quantidade de
                                                    {{ $product['sku'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('quantity.products') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="quantityAdd" class="form-label">Quantidade</label>
                                                        <input type="number" name="quantity" min="1"
                                                            class="form-control" id="quantityAdd" required
                                                            placeholder="Insira a quantidade que queira adicionar">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="action" value="devolution">
                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Adicionar
                                                        Produto</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button data-bs-toggle="modal" data-bs-target="#exitQuantity{{ $count }}"
                                    class="btn btn-danger me-2">Saídas de Produtos</button>

                                <div class="modal fade" id="exitQuantity{{ $count }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Saída das quantidades do
                                                    {{ $product['sku'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('quantity.products') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="quantityAdd" class="form-label">Quantidade</label>
                                                        <input type="number" name="quantity" min="1"
                                                            max="{{ $product['quantity'] }}" class="form-control"
                                                            id="quantityAdd" required
                                                            placeholder="Insira a quantidade que queira adicionar">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="action" value="exit">
                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Adicionar
                                                        Produto</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <form
                                    action="{{ route('delete.products', [
                                        'products' => $product['id'],
                                    ]) }}"
                                    method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger" type="submit"
                                        onclick="confirm('Tem certeza que deseja deletar este produto.')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                </form>

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
