@push('css')
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
@endpush

<div>
    <x-slot name="title">INVOICE SETTING</x-slot>
    <x-slot name="header">INVOICE SETTING</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">Invoice Setting</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent="InvoiceSettingSave">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Invoice Title</label>
                                    <input class="form-control" type="text" wire:model.lazy="invoice_title"
                                        placeholder="Enter Invoice Title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Vat Text</label>
                                    <input class="form-control" type="text" wire:model.lazy="vat_text"
                                        placeholder="Vat Text">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Vat Registration Number</label>
                                    <input class="form-control" type="text" wire:model.lazy="vat_reg_no"
                                        placeholder="Vat Reg Number:">
                                    @error('vat_reg_no') <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Vat Area Code</label>
                                    <input class="form-control" type="text" wire:model.lazy="vat_area_code"
                                        placeholder="Vat Area Code:">
                                    @error('vat_area_code') <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Invoice Type</label>
                                    <select wire:model.lazy="type" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="Invoice">Invoice</option>
                                        <option value="Receipt">Receipt</option>
                                    </select>
                                    @error('type') <span class="error text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Currency</label>
                                    <select wire:model.lazy="currency_id" class="form-control">
                                        <option value="">Select Currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('currency_id') <span
                                        class="error text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Business Email</label>
                                    <input class="form-control" type="text" wire:model.lazy="email"
                                        placeholder="Business Email">
                                </div>
                            </div>

                            <div class="col-md-4 form-group mt-3 mb-3">
                                <label>
                                    Logo
                                    {{-- Start Logo Show --}}
                                    @if (!$logo)
                                        {{-- @if ($InvoiceSettings) --}}
                                        @if ($InvoiceSettings)
                                            <img src="{{ asset('storage/photo/' . $InvoiceSettings->logo) }}"
                                                style="height:30px; weight:30px;" alt="Image2"
                                                class="img-circle img-fluid">
                                        @endif
                                    @endif

                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" style="height:30px; weight:30px;"
                                            alt="Image" class="img-circle img-fluid">
                                    @endif
                                    {{-- End Logo Show --}}
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" wire:model.lazy="logo" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    @error('logo') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 form-group mt-3 mb-3">
                                <label>
                                    Invoice Header Image
                                    {{-- Start Invoice Header Show --}}
                                    @if (!$invoice_header)
                                        @if ($InvoiceSettings)
                                            <img src="{{ asset('storage/photo/' . $InvoiceSettings->invoice_header) }}"
                                                style="height:30px; weight:30px;" alt="Image2"
                                                class="img-circle img-fluid">
                                        @endif
                                    @endif

                                    @if ($invoice_header)
                                        <img src="{{ $invoice_header->temporaryUrl() }}"
                                            style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                    @endif
                                    {{-- End Invoice Header Show --}}
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" wire:model.lazy="invoice_header"
                                        id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    @error('invoice_header') <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 form-group mt-3 mb-3">
                                <label>
                                    Invoice Footer Image
                                    {{-- Start Invoice Header Show --}}
                                    @if (!$invoice_footer)
                                        @if ($InvoiceSettings)
                                            <img src="{{ asset('storage/photo/' . $InvoiceSettings->invoice_footer) }}"
                                                style="height:30px; weight:30px;" alt="Image2"
                                                class="img-circle img-fluid">
                                        @endif
                                    @endif

                                    @if ($invoice_footer)
                                        <img src="{{ $invoice_footer->temporaryUrl() }}"
                                            style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                    @endif
                                    {{-- End Invoice Header Show --}}
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" wire:model.lazy="invoice_footer"
                                        id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    @error('invoice_footer') <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div wire:ignore class="form-group">
                                    <label for="basicpill-lastname-input">Invoice Header</label>
                                    <textarea class="form-control" id="header_title" rows="3"
                                        wire:model.lazy="header_title" placeholder="Content Body" rows="8"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div wire:ignore class="form-group">
                                    <label for="basicpill-lastname-input">Invoice Footer</label>
                                    <textarea class="form-control" id="footer_title" rows="3"
                                        wire:model.lazy="footer_title" placeholder="Content Body" rows="8"></textarea>
                                </div>
                            </div>


                            <div class="col-md-12 form-group">
                                <label></label>
                                <div class="row ml-2 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" wire:model.lazy='is_previous_due'
                                            type="checkbox" id="PrevoiusDueHide">
                                        <label class="form-check-label mt-1" for="PrevoiusDueHide">
                                            Prevoius Due Hide
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='is_paid_due_hide'
                                            type="checkbox" id="DuePaidHide">
                                        <label class="form-check-label mt-1" for="DuePaidHide">
                                            Due Paid Hide
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='is_memo_no_hide'
                                            type="checkbox" id="MemoNoHide">
                                        <label class="form-check-label mt-1" for="MemoNoHide">
                                            Memo No Hide
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='is_chalan_no_hide'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            Chalan No Hide
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='transaction'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            Transaction
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='do_no'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            D.O NO
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='lpo_no'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            L.P.O NO
                                        </label>
                                    </div>

                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='note'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            Note
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label></label>
                                <div class="row ml-2 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" wire:model.lazy='vat'
                                            type="checkbox" id="PrevoiusDueHide">
                                        <label class="form-check-label mt-1" for="PrevoiusDueHide">
                                            VAT %
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='rate'
                                            type="checkbox" id="DuePaidHide">
                                        <label class="form-check-label mt-1" for="DuePaidHide">
                                            Rate (Incl.VAT)
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='discount'
                                            type="checkbox" id="MemoNoHide">
                                        <label class="form-check-label mt-1" for="MemoNoHide">
                                            Discount
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='amount_aed'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            Amount(AED)
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='texable_value'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            Texable Value(AED)
                                        </label>
                                    </div>

                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='vat_aed'
                                            type="checkbox" id="ChalanNoHide">
                                        <label class="form-check-label mt-1" for="ChalanNoHide">
                                            VAT(AED)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div wire:ignore class="form-group">
                                    <label for="basicpill-lastname-input">Invoice Footer</label>
                                    <textarea class="form-control" id="invoice_footer" rows="3"  wire:model.lazy="invoice_footer" placeholder="Footer Description"></textarea>
                                 </div>
                            </div> --}}
                        </div>
                        <center class="mt-2">
                            <button type="submit" value="Submit" class="btn btn-success" data-target="">Update</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

    <script>
        $(document).ready(function() {
            if ($("#header_title").length > 0) {
                tinymce.init({
                    selector: "textarea#header_title",
                    height: 200,
                    forced_root_block: false,
                    setup: function(editor) {
                        editor.on('init change', function() {
                            editor.save();
                        });
                        editor.on('change', function(e) {
                            @this.set('header_title', editor.getContent());
                        });
                    },
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    }, {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    }, {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    }, {
                        title: 'Table styles'
                    }, {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }]
                });

            }
            if ($("#footer_title").length > 0) {
                tinymce.init({
                    selector: "textarea#footer_title",
                    height: 200,
                    forced_root_block: false,
                    setup: function(editor) {
                        editor.on('init change', function() {
                            editor.save();
                        });
                        editor.on('change', function(e) {
                            @this.set('footer_title', editor.getContent());
                        });
                    },
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    }, {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    }, {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    }, {
                        title: 'Table styles'
                    }, {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }]
                });

            }

            $('.summernote').summernote({
                height: 300,
                // set editor height
                minHeight: null,
                // set minimum height of editor
                maxHeight: null,
                // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote

            });
        });
    </script>

@endpush
