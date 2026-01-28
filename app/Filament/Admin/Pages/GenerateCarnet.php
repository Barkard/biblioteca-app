<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class GenerateCarnet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Generar Carnet';
    protected static ?string $title = 'Generar Carnet de Usuario';
    protected string $view = 'filament.admin.pages.generate-carnet';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Seleccionar Usuario')
                        ->schema([
                            Select::make('user_id')
                                ->label('Buscar Usuario (Cédula o Nombre)')
                                ->searchable()
                                ->getSearchResultsUsing(fn (string $search) => User::query()
                                    ->where('id_user', 'like', "%{$search}%")
                                    ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                                    ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($search) . '%'])
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($user) => [$user->id => "{$user->nationality}-{$user->id_user} {$user->name} {$user->last_name}"]))
                                ->getOptionLabelUsing(fn ($value): ?string => ($user = User::find($value)) ? "{$user->nationality}-{$user->id_user} {$user->name} {$user->last_name}" : null)
                                ->required()
                                ->live(), 
                        ]),
                    Wizard\Step::make('Previsualización')
                        ->schema([
                            ViewField::make('preview')
                                ->label('Vista Previa del Carnet')
                                ->view('filament.admin.pages.partials.carnet-preview'),
                        ]),
                    Wizard\Step::make('Descargar')
                        ->schema([
                             ViewField::make('download_step')
                                ->view('filament.admin.pages.partials.generation-step')
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<HTML
                    <x-filament::button 
                        type="submit" 
                        wire:loading.attr="disabled" 
                        wire:target="generate"
                        x-on:click="\$dispatch('start-generation')"
                    >
                        <span wire:loading.remove wire:target="generate">
                            Generar Carnet PDF
                        </span>
                        <span wire:loading wire:target="generate">
                             Generando...
                        </span>
                    </x-filament::button>
                HTML))),
            ])
            ->statePath('data');
    }

    public function getUserProperty()
    {
        return User::find($this->data['user_id'] ?? null);
    }

    public function generate()
    {
        $user = $this->getUserProperty();
        
        if (!$user) {
            Notification::make()
                ->title('Error')
                ->body('No hay usuario seleccionado.')
                ->danger()
                ->send();
            return;
        }

        // Simular retraso de 3 segundos para la barra de carga
        sleep(3);

        Notification::make()
            ->title('¡Carnet generado exitosamente!')
            ->success()
            ->send();

        $pdf = Pdf::loadView('pdf.carnet', ['user' => $user])
            ->setPaper('letter', 'portrait');

        return response()->streamDownload(fn () => print($pdf->output()), 'carnet-' . $user->id_user . '.pdf');
    }
}
