<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\InvoiceSetting as InvoiceSettingModal;
use App\Models\AccountSettings\Currency;
use App\Models\AccountSettings\Branch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceSetting extends Component
{
    use WithFileUploads;

    public $invoice_title;
    public $vat_text;
    public $invoice_header;
    public $logo;
    public $invoice_footer;
    public $vat_reg_no;
    public $vat_area_code;
    public $type;
    public $currency_id;
    public $branch_id;
    public $email;
    public $header_title;
    public $footer_title;
    public $is_previous_due;
    public $is_paid_due_hide;
    public $is_memo_no_hide;
    public $is_chalan_no_hide;
    public $transaction;
    public $vat;
    public $rate;
    public $discount;
    public $amount_aed;
    public $texable_value;
    public $vat_aed;
    public $total_incld_vat;
    public $do_no;
    public $lpo_no;
    public $note;
    public $company_id;
    // public $invoice_footer;
    public $InvoiceSettings=null;

    public function mount(){
        $this->InvoiceSettings=InvoiceSettingModal::first();
            if($this->InvoiceSettings){
                 $this->invoice_title=$this->InvoiceSettings->invoice_title;
                 $this->vat_text=$this->InvoiceSettings->vat_text;
                 $this->vat_reg_no=$this->InvoiceSettings->vat_reg_no;
                 $this->vat_area_code=$this->InvoiceSettings->vat_area_code;
                 $this->type=$this->InvoiceSettings->type;
                 $this->currency_id=$this->InvoiceSettings->currency_id;
                 $this->branch_id=$this->InvoiceSettings->branch_id;
                 $this->email=$this->InvoiceSettings->email;
                 $this->header_title=$this->InvoiceSettings->header_title;
                 $this->footer_title=$this->InvoiceSettings->footer_title;
                 $this->is_previous_due=$this->InvoiceSettings->is_previous_due;
                 $this->is_paid_due_hide=$this->InvoiceSettings->is_paid_due_hide;
                 $this->is_memo_no_hide=$this->InvoiceSettings->is_memo_no_hide;
                 $this->is_chalan_no_hide=$this->InvoiceSettings->is_chalan_no_hide;
                 $this->transaction =$this->InvoiceSettings->transaction;
                 $this->vat = $this->InvoiceSettings->vat;
                 $this->rate = $this->InvoiceSettings->rate;
                 $this->discount = $this->InvoiceSettings->discount;
                 $this->amount_aed = $this->InvoiceSettings->amount_aed;
                 $this->texable_value = $this->InvoiceSettings->texable_value;
                 $this->vat_aed = $this->InvoiceSettings->vat_aed;
                 $this->do_no = $this->InvoiceSettings->do_no;
                 $this->lpo_no = $this->InvoiceSettings->lpo_no;
                 $this->note = $this->InvoiceSettings->note;
            }
    }
    public function InvoiceSettingSave()
    {
        $this->validate([
            'type' => 'required',
           'currency_id' => 'required'
            // 'vat_text' => 'required',
        ]);
        if ($this->InvoiceSettings) {
            $Query =  $this->InvoiceSettings;
        } else {
            $Query = new InvoiceSettingModal();
            $Query->user_id= Auth::id();
            $Query->branch_id = Auth::user()->branch_id;
            $Query->company_id = Auth::user()->company_id;
        }
        $Query->invoice_title = $this->invoice_title;

        $Query->vat_text = $this->vat_text;
        if($this->logo){
            $path = $this->logo->store('/public/photo');
            $Query->logo = basename($path);
        }
        if($this->invoice_header){
            $path = $this->invoice_header->store('/public/photo');
            $Query->invoice_header = basename($path);
        }

        if($this->invoice_footer){
            $path = $this->invoice_footer->store('/public/photo');
            $Query->invoice_footer = basename( $path);
        }

        // $Query->invoice_header = $this->invoice_header;
        // dd($this->type);
        $Query->vat_reg_no = $this->vat_reg_no;
        $Query->vat_area_code = $this->vat_area_code;
        $Query->type = $this->type;
        $Query->currency_id = $this->currency_id;
        $Query->email = $this->email;
        $Query->header_title = $this->header_title;
        $Query->footer_title = $this->footer_title;
        $Query->is_previous_due = $this->is_previous_due;
        $Query->is_paid_due_hide = $this->is_paid_due_hide;
        $Query->is_memo_no_hide = $this->is_memo_no_hide;
        $Query->is_chalan_no_hide = $this->is_chalan_no_hide;
        $Query->transaction = $this->transaction;
        $Query->vat = $this->vat;
        $Query->rate= $this->rate;
        $Query->discount= $this->discount;
        $Query->amount_aed= $this->amount_aed;
        $Query->texable_value= $this->texable_value;
        $Query->vat_aed= $this->vat_aed;
        $Query->do_no = $this->do_no;
        $Query->lpo_no = $this->lpo_no;
        $Query->note = $this->note;
        // $Query->invoice_footer = $this->invoice_footer;
        $Query->save();
        $this->emit('success', ['text' => 'Invoice Settings Update Successfully']);
    }

    public function render()
    {
        return view('livewire.accounts-setting.invoice-setting'
            , [
                'currencies' => Currency::whereCompanyId(Auth::user()->company_id)->get(),
                'branches' => Branch::get()
            ]
        );
    }
}
