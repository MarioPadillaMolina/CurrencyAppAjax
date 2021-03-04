@extends('backend.base')

@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
    <!-- Toastr -->
    <script src="{{ url('assets/backend/plugins/toastr/toastr.min.js') }}"></script>

    @if (session()->get('r') == '1')
        <script type="text/javascript">
            Command: toastr["success"](
                "Currency <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
                "Success")

        </script>
    @endif

    @if (session()->get('r') == '0')
        <script type="text/javascript">
            Command: toastr["error"](
                "Currency <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
                "Success")
        </script>
    @endif

@endsection

@section('poststyle')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <form id="formDelete" action="{{ url('backend/moneda') }}" method="post">
        @method('delete')
        @csrf
    </form>

    <h3>Currency List</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('backend/moneda/create') }}" class="btn btn-primary">Insert new currency</a>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table table-hover">
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
                    @foreach ($monedas as $moneda)
                        <tr>
                            <td>{{ $moneda->id }}</td>
                            <td>{{ $moneda->name }}</td>
                            <td>{{ $moneda->symbol }}</td>
                            <td>{{ $moneda->zone }}</td>
                            <td>{{ $moneda->value }} €</td>
                            <td>{{ date('d-m-Y', strtotime($moneda->creationdate)) }}</td>
                            <td class="text-center"><a href="{{ url('backend/moneda/' . $moneda->id) }}"><i
                                        class="fas fa-eye" aria-hidden="true"></i></a></td>
                            <td class="text-center"><a href="{{ url('backend/moneda/' . $moneda->id . '/edit') }}"><i
                                        class="fas fa-edit" aria-hidden="true"></i></a></td>
                            <td class="text-center"><a href="#" class="launchModal">
                                <i data-id="{{ $moneda->id }}" data-name="{{ $moneda->name }}" data-toggle="modal" 
                                    data-target="#modalDelete" class="fas fa-trash" style="color: darkred; cursor: pointer"></i></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- modal alert -->
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
                    <p>are you sure you want to delete the currency:
                        <strong>ID: <span id="monedaId"></span> - Name: <span id="monedaName"></span></strong> ?
                    </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="modalConfirmation" class="btn btn-primary">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /modal alert -->



@endsection
