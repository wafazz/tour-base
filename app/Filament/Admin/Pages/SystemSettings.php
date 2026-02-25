<?php

namespace App\Filament\Admin\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SystemSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'System Settings';
    protected static ?string $title = 'System Settings';
    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.admin.pages.system-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::get('site_name', 'Tour Base'),
            'site_tagline' => Setting::get('site_tagline'),
            'logo' => Setting::get('logo'),
            'favicon' => Setting::get('favicon'),
            'contact_email' => Setting::get('contact_email'),
            'contact_phone' => Setting::get('contact_phone'),
            'address' => Setting::get('address'),
            'facebook_url' => Setting::get('facebook_url'),
            'instagram_url' => Setting::get('instagram_url'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site_tagline')
                            ->label('Tagline')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Branding')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('branding')
                            ->disk('public')
                            ->maxSize(2048)
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('100'),
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('branding')
                            ->disk('public')
                            ->maxSize(512),
                    ])->columns(2),

                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('contact_phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('address')
                            ->label('Address')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Social Media')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
