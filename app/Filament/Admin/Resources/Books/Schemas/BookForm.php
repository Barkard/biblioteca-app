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
                ->where('title', $title)
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

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->reactive()
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        Rule::unique('books', 'title')
                            ->where(fn ($q) => $q->where('Edition', $get('Edition') ?? ''))
                            ->where(fn ($q) => $q->where('author_id', $get('author_id') ?? ''))
                            ->where(fn ($q) => $q->where('publisher_id', $get('publisher_id') ?? ''))
                            ->ignore($record?->id ?? null),
                    ])
                    ->validationMessages([
                        'unique' => 'Ya existe un libro con este título, edición, autor y editorial.',
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
                    ->reactive()
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        Rule::unique('books', 'Edition')
                            ->where(fn ($q) => $q->where('title', $get('title') ?? ''))
                            ->where(fn ($q) => $q->where('author_id', $get('author_id') ?? ''))
                            ->where(fn ($q) => $q->where('publisher_id', $get('publisher_id') ?? ''))
                            ->ignore($record?->id ?? null),
                    ])
                    ->validationMessages([
                        'unique' => 'Ya existe un libro con este título, edición, autor y editorial.',
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
                    ->required()
                    ->reactive()
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        Rule::unique('books', 'author_id')
                            ->where(fn ($q) => $q->where('title', $get('title') ?? ''))
                            ->where(fn ($q) => $q->where('Edition', $get('Edition') ?? ''))
                            ->where(fn ($q) => $q->where('publisher_id', $get('publisher_id') ?? ''))
                            ->ignore($record?->id ?? null),
                    ])
                    ->validationMessages([
                        'required' => 'El autor es obligatorio.',
                        'unique' => 'Ya existe un libro con este título, edición, autor y editorial.',
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
                    ->required()
                    ->reactive()
                    ->rules(fn (callable $get, $record = null) => [
                        'required',
                        Rule::unique('books', 'publisher_id')
                            ->where(fn ($q) => $q->where('title', $get('title') ?? ''))
                            ->where(fn ($q) => $q->where('Edition', $get('Edition') ?? ''))
                            ->where(fn ($q) => $q->where('author_id', $get('author_id') ?? ''))
                            ->ignore($record?->id ?? null),
                    ])
                    ->validationMessages([
                        'required' => 'La editorial es obligatoria.',
                        'unique' => 'Ya existe un libro con este título, edición, autor y editorial.',
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

                DatePicker::make('date_published'),

                Textarea::make('synopsis')
                    ->columnSpanFull(),



                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
