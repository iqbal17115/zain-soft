@push('css')
@endpush

<div>
    <x-slot name="title">POS TERMINAL</x-slot>
    <x-slot name="header">POS TERMINAL</x-slot>
    <div class="row">
        <div class="nav-item">
            <input type="text" class="form-control" autofocus="on" placeholder="Enter Item Name">
        </div>
        <div class="nav-item ml-2 mr-2 mt-1">
            <button>Add</button>
        </div>
        <div class="nav-item">
            <input type="text" name="" autocomplete="off" autofocus="on" data-type="" class="form-control"
                placeholder="Enter Barcode Scan/Product Code">
        </div>
        <div class="nav-item">
            <input type="text" class="form-control" placeholder="Enter Code">
        </div>
        <div class="nav-item ml-2 mr-2 mt-1">
            <button>+</button>
        </div>
        <div class="nav-item">
            <input type="date" name="" class="form-control" placeholder="Date" value="">
        </div>

        <div class="nav-item">
            <input type="text" name="" class="form-control" placeholder="Enter Memo" value="">
        </div>

        <div class="ml-1 mt-1">
            <label for="">If Multi Pay:
                <input type="checkbox" id="requiringCheck" onclick="requiringcheckFunction()">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">

                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Payment Method</center>
                                        </th>
                                        <th>
                                            <center>Txn Id</center>
                                        </th>
                                        <th>
                                            <center>Amount</center>
                                        </th>
                                        <th>
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <center></center>
                                        </th>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            {{-- <center><button class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash"></i></button></center> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Payment</h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Payment Date</td>
                                    <th>
                                        <input type="date" class="form-control">
                                    </th>
                                </tr>

                                <tr>
                                    <td>Total Amount</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Total Amount">
                                    </th>
                                </tr>

                                <tr>
                                    <td>Discount</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Discount">
                                    </th>
                                </tr>
                                <tr>
                                    <td>Payment Method</td>
                                    <th>
                                        <select class="form-control">
                                            <option>Select Method</option>
                                            <option value=""></option>
                                        </select>
                                    </th>
                                </tr>

                                <tr>
                                    <td>Code</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Code"
                                            wire:model.lazy="payment_code">
                                    </th>
                                </tr>
                                <tr>
                                    <td>Shipping Charge</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Shipping Charge"
                                            wire:model.lazy="payment_code">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Amount to Pay </th>
                                    <th>
                                        <input type="text" class="form-control" name="Amount" placeholder="Amount"
                                            wire:model.lazy="payment_amount">

                                    </th>
                                </tr>

                                <tr>
                                    <td>Due</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Due"
                                            wire:model.lazy="payment_code">
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            <button class="btn btn-warning" type="submit" wire:click="AddPaymentMethod()">Add
                                Payment</button>
                            <button type="submit" class="btn btn-primary" wire:click="Submit">Submit</button>
                        </center>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function callEdit(id) {
            @this.call('PurchaseListEdit', id);
        }

        function callDelete(id) {
            @this.call('PurchaseListDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#SaleListTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.sale-list-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Service Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },

                    {
                        title: 'Sale_price',
                        data: 'sale_price',
                        name: 'sale_price'
                    },

                    {
                        title: 'Action',
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            window.livewire.on('success', message => {
                datatable.draw(true);
            });
        });
    </script>
@endpush
