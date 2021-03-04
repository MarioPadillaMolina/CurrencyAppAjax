@extends('backend.base')
<!-- layout/page -->

@section('poststyle')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/toastr/toastr.min.css') }}">
@endsection

@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
    <!-- Toastr -->
    <script src="{{ url('assets/backend/plugins/toastr/toastr.min.js') }}"></script>
    @if (Session::get('error') !== null)
        <script type="text/javascript">
            Command: toastr["error"]("{{ Session::get('error') }}", "Error")
        </script>
    @endif
@endsection

@section('content')
    <form id="formDelete" action="{{ url('backend/moneda/' . $moneda->id) }}" method="post">
        @method('delete')
        @csrf
    </form>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                    <a href="{{ url('backend/moneda') }}" class="btn btn-primary">Currency List</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Edit: {{ $moneda->name }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ url('backend/moneda/' . $moneda->id) }}" method="post" id="editMonedaForm">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text icono-fijo"><i class="fas fa-money-bill" aria-hidden="true"></i></span>
                                <input type="text" required maxlength="50" minlength="2" class="form-control" name="name"
                                    id="name" placeholder="Currency Name" value="{{ old('name', $moneda->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="symbol">Symbol</label>
                            <div class="input-group-prepend">
                                <!-- forced to lowercase-->
                                <span class="input-group-text icono-fijo"><i class="fas fa-hashtag" aria-hidden="true"></i></span>
                                <input type="text" required maxlength="6" minlength="1" class="form-control" name="symbol"
                                    id="symbol" placeholder="Currency symbol" value="{{ old('symbol', $moneda->symbol) }}" oninput="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zone">Zone</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text icono-fijo"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                <input type="text" required maxlength="80" minlength="3" class="form-control" name="zone"
                                    id="zone" placeholder="Currency zone" value="{{ old('zone', $moneda->zone) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="value">Value (in euro)</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text icono-fijo"><i class="fas fa-euro-sign" aria-hidden="true"></i></span>
                                <input type="number" required class="form-control" min="0.01" max="999999" step="0.01"
                                    name="value" id="value" placeholder="value" value="{{ old('value', $moneda->value) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="creationdate">Creation date</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text icono-fijo"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                                <input type="date" class="form-control" name="creationdate" id="creationdate"
                                    value="{{ old('creationdate', $moneda->creationdate) }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Confirm changes</button>
                        <a href="#" data-id="{{ $moneda->id }}" data-name="{{ $moneda->name }}" data-toggle="modal" data-target="#modalDelete" class="btn btn-danger float-right">Delete</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalDelete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>are you sure you want to delete the currency: <strong>{{ $moneda->name }}</strong> ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" data-id="{{ $moneda->id }}" data-name="{{ $moneda->name }}" class="btn btn-primary" id="enlaceBorrar">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection