<?php

namespace App\Http\Livewire\ProfileSetting;
use App\Actions\Fortify\UpdateUserPassword;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $oldpassword;
    public $newpassword;
    public $password_confirmation;

    public function PasswordChange(UpdateUserPassword $updater)
    {
        $this->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'password_confirmation' => 'required_with:oldpassword|same:newpassword|min:6',
        ]);

        $hashedPassword = Auth::user()->password;

        if (Hash::check($this->oldpassword, $hashedPassword)) {
            if (!Hash::check($this->newpassword, $hashedPassword)) {
                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($this->newpassword);
                User::where('id', Auth::user()->id)->update(['password' => $users->password]);

                $this->emit('success',[
                    'text' => 'Password Changed Successfully',
                ]);
            }
        }
    }
    public function render()
    {
        return view('livewire.profile-setting.change-password');
    }
}
