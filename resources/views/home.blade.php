@extends('default')

@section('name', 'ERP JABB')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center">Histórico</h1>
        @foreach ($logs as $log)
            <div class="card mb-2">
                <div class="card-body text-white bg-{{$log->status}}">
                    <div class="d-flex justify-content-between">
                        <p>{{$log->content}}</p>
                        <p>{{$log->created_at}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    
@endsection