<?php

namespace App\Filament\Admin\Resources\CopyBooks\Schemas;

use App\Models\CopyBook;
use App\Models\Book;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class CopyBookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cota')
                    ->label('Cota')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (TextInput $component, $state) {
                        $livewire = $component->getLivewire();

                        $value = is_string($state) ? trim($state) : $state;

                        // si está vacío, mostrar required y limpiar duplicado
                        if ($value === '' || $value === null) {
                            $message = 'La cota es obligatoria.';
                            $livewire->resetErrorBag('cota');
                            $livewire->resetErrorBag('form.cota');
                            $livewire->resetErrorBag('data.cota');

                            $livewire->addError('cota', $message);
                            $livewire->addError('form.cota', $message);
                            $livewire->addError('data.cota', $message);
                            return;
                        }

                        // Validación de unicidad compuesta (cota única)
                        $validator = Validator::make(
                            ['cota' => $value],
                            ['cota' => ['required', 'string', Rule::unique(CopyBook::class, 'cota')]],
                            ['cota.required' => 'La cota es obligatoria.', 'cota.unique' => 'Ya existe una copia con esa cota.']
                        );

                        if ($validator->fails()) {
                            $message = $validator->errors()->first('cota');

                            // limpiar y añadir error en varias keys para asegurar que Filament lo muestre
                            $livewire->resetErrorBag('cota');
                            $livewire->resetErrorBag('form.cota');
                            $livewire->resetErrorBag('data.cota');

                            $livewire->addError('cota', $message);
                            $livewire->addError('form.cota', $message);
                            $livewire->addError('data.cota', $message);
                        } else {
                            // comprobar existencia manual (excluir registro actual si editando)
                            $query = CopyBook::query()->where('cota', $value);
                            if (isset($livewire->record) && $livewire->record?->id) {
                                $query->where('id', '<>', $livewire->record->id);
                            }
                            $exists = $query->exists();

                            if ($exists) {
                                $message = 'Ya existe una copia con esa cota.';
                                $livewire->resetErrorBag('cota');
                                $livewire->addError('cota', $message);
                            } else {
                                $livewire->resetErrorBag('cota');
                                $livewire->resetErrorBag('form.cota');
                                $livewire->resetErrorBag('data.cota');
                            }
                        }
                    }),

                \Filament\Forms\Components\Hidden::make('book_id')
                    ->required(),

                \Filament\Forms\Components\TextInput::make('book_overview')
                    ->label('Libro Seleccionado')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function ($get) {
                        $bookId = $get('book_id');
                        if (!$bookId) return 'Ningún libro seleccionado';
                        $book = \App\Models\Book::with('author')->find($bookId);
                        return $book ? "{$book->title} - {$book->author->name}" : 'Ningún libro seleccionado';
                    })
                    ->suffixAction(
                        \Filament\Actions\Action::make('select_book')
                            ->label('Buscar Libro')
                            ->icon('heroicon-o-magnifying-glass')
                            ->modalHeading('Seleccionar Libro')
                            ->form([
                                Select::make('temp_book_id')
                                    ->label('Buscar Libro')
                                    ->options(function () {
                                        return Book::with('author')
                                            ->orderBy('title')
                                            ->get()
                                            ->mapWithKeys(function (Book $book) {
                                                return [$book->id => $book->title . ' — ' . ($book->author->name ?? 'Unknown')];
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $book = Book::find($state);
                                        if ($book) {
                                            $set('temp_cover', $book->cover);
                                        }
                                    }),
                                \Filament\Forms\Components\FileUpload::make('temp_cover')
                                    ->label('Portada')
                                    ->image()
                                    ->directory('books/covers')
                                    ->disabled()
                                    ->dehydrated(false)
                            ])
                            ->action(function ($data, $set) {
                                $set('book_id', $data['temp_book_id']);
                                $book = \App\Models\Book::find($data['temp_book_id']);
                                if ($book) {
                                    $set('cover_display', $book->cover);
                                }
                            })
                    ),

                \Filament\Forms\Components\FileUpload::make('cover_display')
                    ->label('Portada')
                    ->image()
                    ->directory('books/covers')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function ($get) {
                         $bookId = $get('book_id');
                         if (!$bookId) return null;
                         return \App\Models\Book::find($bookId)?->cover;
                    }),
            ]);
    }
}
