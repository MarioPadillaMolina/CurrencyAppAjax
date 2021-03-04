@extends('base')

@section('title')
Index
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <h2>Currency App</h2>
            <h3>Currency List</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <table class="table table-hover">
                <tr>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Zone</th>
                    <th>Value</th>
                    <th>Creation Date</th>
                </tr>
                @foreach ($monedas as $moneda)
                <tr>
                    <td>{{ $moneda->name }}</td>
                    <td>{{ $moneda->symbol }}</td>
                    <td>{{ $moneda->zone }}</td>
                    <td>{{ $moneda->value }} €</td>
                    <td>{{ date('d-m-Y', strtotime($moneda->creationdate)) }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection