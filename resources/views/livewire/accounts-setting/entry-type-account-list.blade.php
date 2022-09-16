@push('css')
@endpush

<div>
    <x-slot name="title">Entry Type Account List</x-slot>
    <x-slot name="header">Entry Type Account List</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Assign Chart of Account List</h4>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">SL</th> --}}
                                            <th scope="col">
                                                <center>Chart of Account Name</center>
                                            </th>
                                            <th scope="col">
                                                <center>Assign</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ChartOfAccounts as $ChartOfAccount)
                                        <tr>
                                            {{-- <th scope="row">1</th> --}}
                                            <td>

                                                    <center>{{ $ChartOfAccount->name }}</center>

                                            </td>
                                            <td>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"  wire:model="entrytypecheck.{{$ChartOfAccount['id']}}" id="typeAccountList{{$ChartOfAccount['id']}}" class="custom-control-input" >
                                                    <label class="custom-control-label" for="typeAccountList{{$ChartOfAccount['id']}}"></label>
                                                  </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <center>
                                    <button type="submit" class="btn btn-primary" wire:click="submit">Update</button>
                                </center>
                            </div>


                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function EntryTypeList(id) {
            @this.call('EntryTypeAccountList', id);
        }
        </script>

@endpush
