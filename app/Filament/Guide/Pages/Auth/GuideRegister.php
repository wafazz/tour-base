<?php

namespace App\Filament\Guide\Pages\Auth;

use App\Models\GuideProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class GuideRegister extends Register
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel(),
                TextInput::make('license_no')
                    ->label('Tour Guide License No.'),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): \App\Models\User
    {
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'guide',
            'status' => 'pending',
        ]);

        GuideProfile::create([
            'user_id' => $user->id,
            'license_no' => $data['license_no'] ?? null,
        ]);

        return $user;
    }

    public function register(): ?RegistrationResponse
    {
        $this->callHook('beforeValidate');
        $data = $this->form->getState();
        $this->callHook('afterValidate');

        $this->callHook('beforeRegister');
        $user = $this->handleRegistration($data);
        $this->callHook('afterRegister');

        $this->redirect(route('pending-approval'));
        return null;
    }
}
