<?php

namespace App\Filament\Admin\Resources\Books\Schemas;

use App\Models\Book;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        // campos que participan en la validación compuesta
        $comboFields = ['title', 'Edition', 'author_id', 'publisher_id'];

        // closure helper para chequear existencia y manipular error bags
        $checkCombination = function ($livewire, $title, $edition, $authorId, $publisherId) use ($comboFields) {
            // si falta algún valor no validar aún
            if (! $title || ! $edition || ! $authorId || ! $publisherId) {
                return null;
            }

            $query = Book::query()
                ->whereRaw('LOWER(title) = ?', [strtolower($title)])
                ->where('Edition', $edition)
                ->where('author_id', $authorId)
                ->where('publisher_id', $publisherId);

            // excluir registro actual cuando se edita
            if (isset($livewire->record) && $livewire->record?->id) {
                $query->where('id', '<>', $livewire->record->id);
            }

            $exists = $query->exists();

            if ($exists) {
                $message = 'Ya existe un libro con ese título, edición, autor y editorial.';
                foreach ($comboFields as $key) {
                    $livewire->resetErrorBag($key);
                    $livewire->addError($key, $message);
                    $livewire->addError("form.{$key}", $message);
                    $livewire->addError("data.{$key}", $message);
                }
            } else {
                foreach ($comboFields as $key) {
                    $livewire->resetErrorBag($key);
                    $livewire->resetErrorBag("form.{$key}");
                    $livewire->resetErrorBag("data.{$key}");
                }
            }

            return $exists;
        };

        $validateUnique = function (callable $get, $record = null) {
            return function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                $title = $get('title');
                $edition = $get('Edition');
                $authorId = $get('author_id');
                $publisherId = $get('publisher_id');

                if (! $title || ! $edition || ! $authorId || ! $publisherId) {
                    return;
                }

                $query = Book::query()
                    ->whereRaw('LOWER(title) = ?', [strtolower($title)])
                    ->where('Edition', $edition)
                    ->where('author_id', $authorId)
                    ->where('publisher_id', $publisherId);

                if ($record && $record->id) {
                    $query->where('id', '<>', $record->id);
                }

                if ($query->exists()) {
                    $fail('Ya existe un libro con este título (mismo nombre, edición, autor y editorial).');
                }
            };
        };

        $runCombinationCheck = function ($livewire) use ($checkCombination) {
            $data = method_exists($livewire, 'getState') ? $livewire->getState() : (property_exists($livewire, 'data') ? $livewire->data : []);

            $title = $data['title'] ?? ($livewire->record->title ?? null);
            $edition = $data['Edition'] ?? ($livewire->record->Edition ?? null);
            $authorId = $data['author_id'] ?? ($livewire->record->author_id ?? null);
            $publisherId = $data['publisher_id'] ?? ($livewire->record->publisher_id ?? null);

            $checkCombination($livewire, $title, $edition, $authorId, $publisherId);
        };

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(onBlur: true)
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        $validateUnique($get, $record),
                    ])
                    ->afterStateUpdated(function (TextInput $component, $state) use ($checkCombination) {
                        $livewire = $component->getLivewire();
                        $data = method_exists($livewire, 'getState') ? $livewire->getState() : (property_exists($livewire, 'data') ? $livewire->data : []);
                        $title = $state;
                        $edition = $data['Edition'] ?? ($livewire->record->Edition ?? null);
                        $authorId = $data['author_id'] ?? ($livewire->record->author_id ?? null);
                        $publisherId = $data['publisher_id'] ?? ($livewire->record->publisher_id ?? null);

                        $checkCombination($livewire, $title, $edition, $authorId, $publisherId);
                    }),

                TextInput::make('Edition')
                    ->label('Edición')
                    ->required()
                    ->live(onBlur: true)
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        $validateUnique($get, $record),
                    ])
                    ->afterStateUpdated(function (TextInput $component, $state) use ($checkCombination) {
                        $livewire = $component->getLivewire();
                        $data = method_exists($livewire, 'getState') ? $livewire->getState() : (property_exists($livewire, 'data') ? $livewire->data : []);
                        $title = $data['title'] ?? ($livewire->record->title ?? null);
                        $edition = $state;
                        $authorId = $data['author_id'] ?? ($livewire->record->author_id ?? null);
                        $publisherId = $data['publisher_id'] ?? ($livewire->record->publisher_id ?? null);

                        $checkCombination($livewire, $title, $edition, $authorId, $publisherId);
                    }),

                Select::make('author_id')
                    ->label('Autor')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del Autor')
                            ->rules([
                                fn () => function (string $attribute, $value, \Closure $fail) {
                                    if (\App\Models\Author::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists()) {
                                        $fail('Ya existe un autor con este nombre.');
                                    }
                                },
                            ]),
                    ])
                    ->createOptionAction(function ($action) use ($runCombinationCheck) {
                        return $action
                            ->after(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            })
                            ->modalCancelAction(fn ($action) => $action->action(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            }));
                    })
                    ->required()
                    ->live(onBlur: true)
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        $validateUnique($get, $record),
                    ])
                    ->validationMessages([
                        'required' => 'El autor es obligatorio.',
                    ])
                    
                    ->afterStateUpdated(function ($component, $state) use ($checkCombination) {
                        $livewire = $component->getLivewire();
                        $data = method_exists($livewire, 'getState') ? $livewire->getState() : (property_exists($livewire, 'data') ? $livewire->data : []);
                        $title = $data['title'] ?? ($livewire->record->title ?? null);
                        $edition = $data['Edition'] ?? ($livewire->record->Edition ?? null);
                        $authorId = $state;
                        $publisherId = $data['publisher_id'] ?? ($livewire->record->publisher_id ?? null);

                        $checkCombination($livewire, $title, $edition, $authorId, $publisherId);
                    }),

                Select::make('publisher_id')
                    ->label('Editorial')
                    ->relationship('publisher', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre de la Editorial')
                            ->rules([
                                fn () => function (string $attribute, $value, \Closure $fail) {
                                    if (\App\Models\Publisher::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists()) {
                                        $fail('Ya existe una editorial con este nombre.');
                                    }
                                },
                            ]),
                    ])
                    ->createOptionAction(function ($action) use ($runCombinationCheck) {
                        return $action
                            ->after(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            })
                            ->modalCancelAction(fn ($action) => $action->action(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            }));
                    })
                    ->required()
                    ->live(onBlur: true)
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        $validateUnique($get, $record),
                    ])
                    ->validationMessages([
                        'required' => 'La editorial es obligatoria.',
                    ])
                    ->afterStateUpdated(function ($component, $state) use ($checkCombination) {
                        $livewire = $component->getLivewire();
                        $data = method_exists($livewire, 'getState') ? $livewire->getState() : (property_exists($livewire, 'data') ? $livewire->data : []);
                        $title = $data['title'] ?? ($livewire->record->title ?? null);
                        $edition = $data['Edition'] ?? ($livewire->record->Edition ?? null);
                        $authorId = $data['author_id'] ?? ($livewire->record->author_id ?? null);
                        $publisherId = $state;

                        $checkCombination($livewire, $title, $edition, $authorId, $publisherId);
                    }),

                DatePicker::make('date_published')
                    ->label('Fecha de Publicación'),

                Textarea::make('synopsis')
                    ->label('Sinopsis')
                    ->columnSpanFull(),



                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre de la Categoría')
                            ->rules([
                                fn () => function (string $attribute, $value, \Closure $fail) {
                                    if (\App\Models\Category::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists()) {
                                        $fail('Ya existe una categoría con este nombre.');
                                    }
                                },
                            ]),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(function ($action) use ($runCombinationCheck) {
                        return $action
                            ->after(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            })
                            ->modalCancelAction(fn ($action) => $action->action(function ($livewire) use ($runCombinationCheck) {
                                $runCombinationCheck($livewire);
                            }));
                    })
                    ->required(),
            ]);
    }
}
