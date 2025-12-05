<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use App\Models\Category; // Asegúrate de importar tu modelo Category
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryForm
{
    /**
     * Define los componentes del formulario para la creación/edición de categorías.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de la Categoría')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (TextInput $component, $state) {
                        $validator = Validator::make(
                            ['name' => $state],
                            [
                                'name' => ['required', 'string', Rule::unique(Category::class, 'name')],
                            ],
                            [
                                'name.unique' => 'El nombre de la categoría ya existe. Por favor, elige otro.',
                                'required' => 'El nombre de la categoría es obligatorio.',
                            ]
                        );

                        $livewire = $component->getLivewire();

                        if ($validator->fails()) {
                            $message = $validator->errors()->first('name');

                            // Limpiamos posibles errores previos y añadimos el nuevo
                            $livewire->resetErrorBag('name');
                            $livewire->resetErrorBag('form.name');
                            $livewire->resetErrorBag('data.name');

                            $livewire->addError('name', $message);
                            $livewire->addError('form.name', $message);
                            $livewire->addError('data.name', $message);
                        } else {
                            // Limpiamos todas las posibles keys
                            $livewire->resetErrorBag('name');
                            $livewire->resetErrorBag('form.name');
                            $livewire->resetErrorBag('data.name');
                        }
                    }),

                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->validationMessages([
                        'maxLength' => 'La descripción es demasiado larga.',
                    ]),
            ]);
    }
}