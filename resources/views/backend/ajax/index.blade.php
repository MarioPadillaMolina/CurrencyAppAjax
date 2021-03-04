@extends('backend.base')

@section('postscript')
<script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
<script src="{{ url('assets/backend/js/currency.js?=' . uniqid()) }}"></script>
<!-- Toastr -->
<script src="{{ url('assets/backend/plugins/toastr/toastr.min.js') }}"></script>


<script type="text/javascript">
    if(false) {
    Command: toastr["success"](
        "Currency <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
        "Success")
    }
    if (false) {
        Command: toastr["error"](
            "Currency <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
            "Success")
        }
</script>

@endsection

@section('poststyle')
<!-- Toastr -->
<link rel="stylesheet" href="{{ url('assets/backend/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/backend/css/currency.css') }}">
@endsection

{{-- Modales --}}
@section('modalBodyEdit')
<input type="hidden" class="form-control" id="_method" name="_method" value="put">
<input type="hidden" class="form-control" id="_route" name="_route" value="">
<form id="currencyForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Name</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-money-bill" aria-hidden="true"></i></span>
                <input type="text" required maxlength="50" minlength="2" class="form-control" name="name" id="name"
                    placeholder="Currency Name" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="symbol">Symbol</label>
            <div class="input-group-prepend">
                <!-- forced to lowercase-->
                <span class="input-group-text icono-fijo"><i class="fas fa-hashtag" aria-hidden="true"></i></span>
                <input type="text" required maxlength="6" minlength="1" class="form-control" name="symbol" id="symbol"
                    placeholder="Currency symbol" value="" oninput="this.value = this.value.toUpperCase()">
            </div>
        </div>
        <div class="form-group">
            <label for="zone">Zone</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fa fa-globe" aria-hidden="true"></i></span>
                <input type="text" required maxlength="80" minlength="3" class="form-control" name="zone" id="zone"
                    placeholder="Currency zone" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="value">Value (in euro)</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-euro-sign" aria-hidden="true"></i></span>
                <input type="number" required class="form-control" min="0.01" max="999999" step="0.01" name="value"
                    id="value" placeholder="value" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="creationdate">Creation date</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                <input type="date" class="form-control" name="creationdate" id="creationdate" value="">
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</form>
@endsection

@section('modalBodyAdd')
<input type="hidden" class="form-control" id="_methodAdd" name="_method" value="put">
<input type="hidden" class="form-control" id="_routeAdd" name="_route" value="url('ajaxcurrency')">
<form id="addCurrencyForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Name</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-money-bill" aria-hidden="true"></i></span>
                <input type="text" required maxlength="50" minlength="2" class="form-control" name="name" id="name"
                    placeholder="Currency Name" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="symbol">Symbol</label>
            <div class="input-group-prepend">
                <!-- forced to lowercase-->
                <span class="input-group-text icono-fijo"><i class="fas fa-hashtag" aria-hidden="true"></i></span>
                <input type="text" required maxlength="6" minlength="1" class="form-control" name="symbol" id="symbol"
                    placeholder="Currency symbol" value="" oninput="this.value = this.value.toUpperCase()">
            </div>
        </div>
        <div class="form-group">
            <label for="zone">Zone</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fa fa-globe" aria-hidden="true"></i></span>
                <input type="text" required maxlength="80" minlength="3" class="form-control" name="zone" id="zone"
                    placeholder="Currency zone" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="value">Value (in euro)</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-euro-sign" aria-hidden="true"></i></span>
                <input type="number" required class="form-control" min="0.01" max="999999" step="0.01" name="value"
                    id="value" placeholder="value" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="creationdate">Creation date</label>
            <div class="input-group-prepend">
                <span class="input-group-text icono-fijo"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                <input type="date" class="form-control" name="creationdate" id="creationdate" value="">
            </div>
        </div>
    </div>
</form>
@endsection

@section('modalBodyDelete')
<div class="card-body">
    <div class="form-group">
        Sure to delete currency with name <span id="nameBorrar"></span>?
        {{-- <input type="hidden" required class="form-control" id="_tokenDelete" name="_token" value=""> --}}
    </div>
</div>
@endsection

@section('modal')
@include('backend.ajax.include.modal', ['id' => 'edit', 'title' => 'Edit Currency', 'actionButton' => 'Save Currency',
'modalBody' => 'modalBodyEdit'])
@include('backend.ajax.include.modal', ['id' => 'add', 'title' => 'Add Currency', 'actionButton' => 'Add Currency',
'modalBody' => 'modalBodyAdd'])
@include('backend.ajax.include.modal', ['id' => 'delete', 'title' => 'Delete Currency', 'actionButton' => 'Delete
Currency',
'modalBody' => 'modalBodyDelete'])
@endsection



@section('content')
<h3>Currency List</h3>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#addModal" class="btn btn-primary">Insert
                    new currency</a>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>id #</th>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Zone</th>
                        <th>Value</th>
                        <th>Creation Date</th>
                        <th class="text-center">show</th>
                        <th class="text-center">edit</th>
                        <th class="text-center">delete</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    {{-- aquí va la mandanga que pinta ajax --}}
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-6">
                    <nav>
                        <ul class="pagination" id="enlacesPaginacion">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection