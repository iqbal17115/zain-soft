<?php

namespace App\Http\Livewire\ProfileSetting;
use App\Models\User;
use App\Models\AccountSettings\Branch;
use App\Models\Setting\Company;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class UsersManagement extends Component
{
    use WithFileUploads;
    public $name;
    public $mobile;
    public $email;
    public $password;
    public $password_confirmation;
    public $branch_id;
    public $UserId;
    public $company_id;
    public $user_id=null;
    public $profile_photo_path=NULL;
    public $QueryUpdate=NULL;
    public $user_role;
    /**
     *New User Create
     */
    public function UserPermission()
    {
        $this->reset();
        $this->emit('modal', 'UserPermission');
    }
    public function UserSave()
    {
        $this->validate([
            'name'     => 'required',
            'mobile'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
            'user_role' => 'required',
            'company_id' => 'required',

        ]);
        if ($this->user_id) {
            $Query = User::find($this->user_id);
        } else {
            $Query = new User();
            $Query->current_team_id = Auth::id();
			$Query->password = Hash::make($this->password);
        }
        $Query->name = $this->name;
        $Query->mobile = $this->mobile;
        $Query->email = $this->email;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        $Query->syncRoles($this->user_role);
        if (!$this->user_id) {
            $Query->givePermissionTo(Permission::all());
        }
        $this->UserModal();

        $this->emit('success', [
            'text' => 'User Created Successfully',
        ]);
    }
    /**
     * User Update
     */
    public function UserEditSave()
    {
        $this->validate([
            'name'     => 'required',
            'mobile'    => 'required',
            'email'    => 'required|email',
            'user_role' => 'required',
            'company_id' => 'required',
        ]);
        if ($this->user_id) {
            $Query = User::find($this->user_id);
        } else {
            $Query = new User();
            $Query->current_team_id = Auth::id();
        }
        $Query->name = $this->name;
        $Query->mobile = $this->mobile;
        $Query->email = $this->email;
        $Query->branch_id = $this->branch_id;
        $Query->company_id = $this->company_id;
        $Query->save();
        $Query->syncRoles($this->user_role);
        if (!$this->user_id) {
            $Query->givePermissionTo(Permission::all());
        }
        $this->UserEditModal();
        $this->emit('success', [
            'text' => 'User Updated Successfully',
        ]);
    }
    public function UserEdit($id)
    {
        $this->QueryUpdate = User::find($id);
        $this->user_id = $this->QueryUpdate->id;
        $this->name = $this->QueryUpdate->name;
        $this->mobile = $this->QueryUpdate->mobile;
        $this->email = $this->QueryUpdate->email;
        $this->branch_id = $this->QueryUpdate->branch_id;
        $this->company_id = $this->QueryUpdate->company_id;
        $this->user_role = $this->QueryUpdate->getRoleNames();
		$this->emit('modal', 'UserEditBox');
    }
    public function UserEditModal()
    {
        $this->reset();
        $this->emit('modal', 'UserEditBox');
    }
    /**
     * Change Password
     */
    public function PasswordUpdate()
    {
        $this->validate([
            'password' => 'required',
            'password_confirmation' => 'required_with:oldpassword|same:password|min:6',
        ]);

        $users = User::find($this->UserId);
        $users->password = Hash::make($this->password);
        User::where('id', $users->id)->update(['password' => $users->password]);

        $this->emit('success', [
            'text' => 'Password Changed Successfully',
        ]);
        $this->emit('success', [
            'text' => 'Password Updated Successfully',
        ]);
    }
    public function PasswordChange($id)
    {
        $this->UserId=$id;
		$this->emit('modal', 'PasswordModalBox');
    }
    /**
     * User Delete
     */
    public function UserDelete($id)
    {
        User::find($id)->delete();

        $this->emit('success', [
            'text' => 'User Deleted Successfully',
        ]);
    }
    public function UserModal()
    {
        $this->reset();
        $this->emit('modal', 'UserModalBox');
    }
    public function render()
    {
        return view('livewire.profile-setting.users-management',
        ['branches'=>Branch::get(),
        'companies'  =>Company::get(),
    ]);
    }
}
