@push('css')
@endpush

<div>
    <x-slot name="title">DELIEVERY NOTE</x-slot>
    <x-slot name="header">DELIEVERY NOTE</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="col-md-12">
                        <img src="{{ asset('storage/photo/'.$profilesetting->logo)}}" alt="logo" height="50"
                            width="100">
                    </div>
                    <div class="col-md-12 mt-4">
                        <p class="text-center"><strong><u>Delievery Note</u></strong></p>
                    </div>

                    <div class="d-flex justify-content-between ml-3">
                        <div>
                            <p>Ref No: Z234567</p>
                        </div>
                        <div>
                            <p>Date No:12-09-2021</p>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <p class="text-sm-left">From,
                            <br>Zain Technologies lltd
                            <br>Shop no: 6 Al Souq Al Kabeer
                            <br>Bur Dubei, UAE
                            <br> T: +97143531140
                        </p>
                    </div>

                    <div class="d-flex justify-content-between ml-3">
                        <div>
                            <p>To,
                                <br>Emitec Enterprize Solution LLC,
                                <br>Sarjah, United Arab Amirates,
                            </p>
                        </div>
                        <div>
                            <p>Delievered To: Mr.Anto
                                <br>Mobile No: + 912345678
                                <br>Invoice No: S123455
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <p class="text-left"><strong>Kindly Attention: Myra Cruz</strong></p>
                    </div>

                    <div class="col-md-12">
                        <p class="text-left"><strong>Thannks for your Order below mentioned item has been
                                delievered to Mr. Anto</strong></p>
                    </div>
                    <div class="row mb-2">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Production Specification</th>
                                        <th>Unit</th>
                                        <th>Serial No</th>
                                        <th>CARTOON</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td>1</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                    </tr>
                                    </tr>

                                    <tr>
                                    <tr>
                                        <td>1</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                    </tr>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between ml-3">
                        <div>
                            <p>Thanking you,
                                <br>For Zain Technologies LLC,
                                <br class="mt-3">GM Rasedul Islam
                            </p>
                        </div>
                        <div>
                            <p>Emitec Enterprize Solution LLC,
                                <br mt-3> Myra Cruz
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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

            var datatable = $('#AddStockAdjustmentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.add-stock-adjustment-table') }}",
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
