@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="width: 100%">
                        <div class="row">
                            <div class="col-md-8">
                                <a href="{{ route('transactions.create') }}"
                                    class="btn btn-sm btn-primary pull-right">Create New Transaction</a>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="status">
                                    <option value="2">All</option>
                                    <option value="1">Finished</option>
                                    <option value="0">Unfinished</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="date">
                                    <option value="2">All</option>
                                    <option value="month">this month</option>
                                    <option value="1">Over late</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-body" style="width: 100%">
                        <table id="dataTables" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Date start</th>
                                    <th>Date End</th>
                                    <th>Name</th>
                                    <th>Period of loan(Days)</th>
                                    <th>total books</th>
                                    <th>total price</th>
                                    <th>status</th>
                                    <th class="text-right">action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript">
        var actionUrl = `{{ url('transactions') }}`;
        var apiUrl = `{{ url('api/transactions') }}`;

        var columns = [{
                data: 'date_start',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'date_end',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'name',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'period',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'total_book',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'rupiah',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'status_transaction',
                class: 'text-center',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
              <a href="{{ url('/transactions/${data.transaction_id}/edit') }}" class="btn btn-warning btn-sm">
                Edit
                </a>
                <a href="{{ url('/transactions/${data.transaction_id}/show') }}" class="btn btn-primary btn-sm">
                Show
                </a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.transaction_id})">
                Delete
                </a>`;
                },
                orderable: false,
                width: "200px",
                class: "text-center"
            },
        ];
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl,
                apiUrl,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#dataTables').DataTable({
                        ajax: {
                            url: _this.apiUrl + '?status=2',
                            type: 'GET',
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                },
                numberWithSpaces(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                },
                deleteData(event, id) {
                    if (confirm("Are you sure?")) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            alert('Data has been remove');
                            _this.table.ajax.json();
                        });
                    }
                },
            }
        });

        $('select[name=status]').on('change', function() {
            status = $('select[name=status]').val();

            controller.table.ajax.url(apiUrl + '?status=' + status).load();

        });
        $('select[name=date]').on('change', function() {
            date= $('select[name=date]').val();

            controller.table.ajax.url(apiUrl + '?date=' + date).load();

        });
    </script>
@endsection
