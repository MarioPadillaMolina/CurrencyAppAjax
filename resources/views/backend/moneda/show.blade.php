@extends('backend.base')
<!-- layout/page -->

@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <h2>Show Currency Details</h2>
    @if (Session::get('error') !== null)
        <h2>
            {{ Session::get('error') }}
        </h2>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $moneda->name }} details </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $moneda->name }}</td>
                            </tr>
                            <tr>
                                <th>Symbol</th>
                                <td>{{ $moneda->symbol }}</td>
                            </tr>
                            <tr>
                                <th>Zone</th>
                                <td>{{ $moneda->zone }}</td>
                            </tr>
                            <tr>
                                <th>Value</th>
                                <td>{{ $moneda->value }}</td>
                            </tr>
                            <tr>
                                <th>Creation Date</th>
                                <td>{{ date('d-m-Y', strtotime($moneda->creationdate)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ url('backend/moneda/' . $moneda->id . '/edit') }}" class="btn btn-warning">Edit</a>
                    <a href="#" data-id="{{ $moneda->id }}" data-name="{{ $moneda->name }}" data-toggle="modal" data-target="#modalDelete" class="btn btn-danger float-right">Delete</a>                
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!--modal alert-->
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
    <form id="formDelete" action="{{ url('backend/moneda/' . $moneda->id) }}" method="post">
        @method('delete')
        @csrf
    </form>
@endsection
