@push('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

<div>
    <x-slot name="title">
        {{$EntryType->name}} Add
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
					 <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-2 mr-2 search-box d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title">{{$EntryType->name}} Add</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a href="{{route('accounts-module.receipt-list')}}"><button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">Entries list </button></a>
                            </div>
                        </div>

                    </div><hr>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Date</label><br>
                                <input type="date" wire:model.lazy="date" class="form-control" />
                                @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                           </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="basicpill-lastname-input">Receipt No</label>
                                <input type="text" wire:model.lazy="code" placeholder="Code" class="form-control"
                                    id="basicpill-lastname-input">
                                    @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="basicpill-lastname-input">Tag</label>
                                <select wire:model.lazy="tag_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($Tag as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                                @error('tag_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <select wire:model.lazy="item_type" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                </select>
                                @error('item_type') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <select wire:model="item_chart_of_account_id" class="form-control">
                                    <option value="">Select Chart of Account</option>
                                    @foreach($ChartOfAccount as $item)
                                       <option value="{{$item->chart_of_account_id}}">{{$item->ChartOfAccount->name}}</option>
                                    @endforeach
                                </select>
                                @error('item_chart_of_account_id') <span class="error text-danger">{{ $message }}</span> @enderror

                                @if($ChartOfAccountCheque)
                                <label for="example-search-input" class="col-16 col-form-label">
                                    <input type="checkbox" wire:model="ifCheque" id="ifCheque" name="ifCheque">
                                    Cheque
                                </label>
                                @endif
                            </div>
                        </div>
                        @if($ifCheque)
                        <div class="col-md-3">
                                <input type="date" wire:model.lazy="cheque_date" class="form-control">
                        </div>
                        @endif

                        <div class="col-lg-3">
                            <div class="form-group">
                                <select wire:model="item_contact_id" class="form-control" wire:model.lazy="contact_id" id="contact_id">
                                    <option value="">Select Contact</option>
                                    @foreach($Contact as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                    @endforeach
                                </select>
                                @error('item_contact_id') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="text" wire:model.lazy="item_amount" placeholder="Amount" class="form-control"
                                    id="basicpill-lastname-input">
                                    @error('item_amount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <button class="btn btn-primary" wire:click="add" type="button">Add</button>
                            </div>
                        </div>
                     </div>
                    <div class="table-responsive">
                        <table class="table mb-0 table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Contact Name</th>
                                    <th>Dr Amount</th>
                                    <th>Cr Amount</th>

                                    <th colspan="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartList as $key => $item)
                                <tr>
                                    <td>
                                     {{$type[$key]}}
                                    </td>
                                    <td>
                                        {{$item['chart_of_account_name']}}
                                    </td>
                                    <td>
                                        {{$cheque_payment_date[$key]}}
                                    </td>
                                    <td>
                                        {{$item['contact_name']}}
                                    </td>

                                    <td>
                                        {{$dr_amount[$key]}}
                                    </td>
                                    <td>
                                        {{$cr_amount[$key]}}
                                    </td>

                                    <td>
                                        <a class="btn btn-danger btn-sm" href="#" role="button"
                                            wire:click="removeItem({{$key}})">Remove</a>
                                    </td>
                                </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td>{{$dr_amount_total}}</td>
                                        <td>{{$cr_amount_total}}</td>
                                        <td></td>
                                    </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 card-title">Note</h4>
                        <div class="form-group">
                            <textarea cols="2" wire:model.lazy="note" rows="4" class="form-control"></textarea>
                            @error('note') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 card-title">Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Grand Total Debit :</td>
                                     <td>{{$dr_amount_total}}</td>
                                </tr>
                                <tr>
                                    <td>Grand Total Credit :</td>
                                     <td>{{$cr_amount_total}}</td>
                                </tr>


                            </tbody>
                        </table>
                        <center>
                            <button class="btn btn-warning" type="submit">Cancelled</button>
                            <button class="btn btn-primary" wire:click="Submit" type="button">Submit</button>
                        </center>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
    <!-- end row -->
</div>
@push('scripts')
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script>
    // Start Select2
    $(document).ready(function() {
     $('.select2').select2({
             placeholder: '{{__('Select Supplier')}}',
             allowClear: true
         });
         $('.select2').on('change', function (e) {
             let elementName = $(this).attr('id');
             var data = $(this).select2("val");
             @this.set(elementName, data);
         });
 });
//    End Select2
</script>

@endpush


