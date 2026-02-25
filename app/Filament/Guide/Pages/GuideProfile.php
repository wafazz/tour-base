<?php

namespace App\Filament\Guide\Pages;

use App\Models\Document;
use App\Models\GuideProfile as GuideProfileModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class GuideProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.guide.pages.guide-profile';

    public ?array $data = [];

    public ?array $documentData = [];

    public function mount(): void
    {
        $profile = Auth::user()->guideProfile;

        $this->form->fill([
            'license_no' => $profile?->license_no,
            'experience_years' => $profile?->experience_years ?? 0,
            'skills' => $profile?->skills ?? [],
            'languages' => $profile?->languages ?? [],
            'social_links' => $profile?->social_links ?? [],
            'bio' => $profile?->bio,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Professional Information')
                    ->schema([
                        Forms\Components\TextInput::make('license_no')
                            ->label('Tour Guide License No.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('experience_years')
                            ->label('Years of Experience')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(50),
                        Forms\Components\TagsInput::make('skills')
                            ->label('Skills')
                            ->placeholder('Add a skill')
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('languages')
                            ->label('Languages')
                            ->placeholder('Add a language')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('About Me')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Bio')
                            ->rows(4)
                            ->placeholder('Tell agencies about yourself...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Social Links')
                    ->schema([
                        Forms\Components\KeyValue::make('social_links')
                            ->label('')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->keyPlaceholder('e.g. LinkedIn')
                            ->valuePlaceholder('https://...')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function documentForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Upload Documents')
                    ->description('Upload your license, passport, certificates, or other relevant documents.')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Document Type')
                            ->options([
                                'license' => 'License',
                                'passport' => 'Passport',
                                'cert' => 'Certificate',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('file')
                            ->label('File')
                            ->disk('public')
                            ->directory('guide-documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->required(),
                    ])->columns(2),
            ])
            ->statePath('documentData');
    }

    protected function getForms(): array
    {
        return [
            'form',
            'documentForm',
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        GuideProfileModel::updateOrCreate(
            ['user_id' => Auth::id()],
            $data,
        );

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }

    public function uploadDocument(): void
    {
        $data = $this->documentForm->getState();

        Document::create([
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'file_path' => $data['file'],
            'original_name' => $data['file'],
        ]);

        $this->documentForm->fill();

        Notification::make()
            ->title('Document uploaded successfully')
            ->success()
            ->send();
    }

    public function deleteDocument(int $documentId): void
    {
        $doc = Document::where('id', $documentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        Notification::make()
            ->title('Document deleted')
            ->success()
            ->send();
    }

    public function getDocuments(): \Illuminate\Database\Eloquent\Collection
    {
        return Document::where('user_id', Auth::id())
            ->latest()
            ->get();
    }
}
