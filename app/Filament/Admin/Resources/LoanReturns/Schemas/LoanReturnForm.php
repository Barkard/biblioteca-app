<?php

namespace App\Filament\Admin\Resources\LoanReturns\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LoanReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('return_date')
                    ->label('Fecha de Devolución'),

                Select::make('user_id')
                    ->label('Usuario')
                    ->options(function () {
                        return User::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(function (User $u) {
                                return [$u->id => $u->id_user . ' - ' . $u->name . ' ' . $u->last_name];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                \Filament\Forms\Components\Repeater::make('loanDetails')
                    ->relationship()
                    ->columns(4)
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->schema([
                        \Filament\Forms\Components\Hidden::make('copy_book_id'),
                        \Filament\Forms\Components\Hidden::make('cota'), // Keep cota for logic but hidden from list
                        \Filament\Forms\Components\TextInput::make('book_title')
                            ->hiddenLabel()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1)
                            ->formatStateUsing(fn ($record, $state) => $record?->copyBook?->book?->title ?? $state),
                        \Filament\Forms\Components\TextInput::make('book_author')
                            ->hiddenLabel()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1)
                            ->formatStateUsing(fn ($record, $state) => $record?->copyBook?->book?->author?->name ?? $state),
                        \Filament\Forms\Components\TextInput::make('book_edition')
                            ->hiddenLabel()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1)
                            ->formatStateUsing(fn ($record, $state) => $record?->copyBook?->book?->Edition ?? $state),
                        \Filament\Forms\Components\TextInput::make('book_editorial')
                            ->hiddenLabel()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1)
                            ->formatStateUsing(fn ($record, $state) => $record?->copyBook?->book?->publisher?->name ?? $state),
                    ])
                    ->table([
                        \Filament\Forms\Components\Repeater\TableColumn::make('Título'),
                        \Filament\Forms\Components\Repeater\TableColumn::make('Autor'),
                        \Filament\Forms\Components\Repeater\TableColumn::make('Edición'),
                        \Filament\Forms\Components\Repeater\TableColumn::make('Editorial'),
                    ])
                    ->addAction(function ($action) {
                        return $action
                            ->label('Añadir ejemplar o libro')
                            ->modalHeading('Añadir ejemplar')
                            ->form([
                                Select::make('copy_book_id')
                                    ->label('Ejemplar')
                                    ->options(function () {
                                        return \App\Models\CopyBook::query()
                                            ->where('status', true)
                                            ->with('book')
                                            ->get()
                                            ->mapWithKeys(function ($copy) {
                                                return [$copy->id => "{$copy->book->title} - {$copy->cota} (Disponible)"];
                                            });
                                    })
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $copy = \App\Models\CopyBook::with('book.author', 'book.publisher')->find($state);
                                        if ($copy) {
                                            $set('book_title', $copy->book->title);
                                            $set('book_author', $copy->book->author->name ?? 'N/A');
                                            $set('book_edition', $copy->book->Edition);
                                            $set('book_editorial', $copy->book->publisher->name ?? 'N/A');
                                            $set('cota', $copy->cota);
                                            $set('cover_preview', $copy->book->cover);
                                        }
                                    }),
                                \Filament\Schemas\Components\Grid::make(4)
                                    ->schema([
                                        \Filament\Forms\Components\FileUpload::make('cover_preview')
                                            ->label('Portada')
                                            ->image()
                                            ->directory('books/covers')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->columnSpan(1),
                                        \Filament\Schemas\Components\Group::make()
                                            ->schema([
                                                TextInput::make('book_title')
                                                    ->label('Título')
                                                    ->disabled()
                                                    ->dehydrated(),
                                                TextInput::make('book_author')
                                                    ->label('Autor')
                                                    ->disabled()
                                                    ->dehydrated(),
                                            ])->columnSpan(2),
                                        \Filament\Schemas\Components\Group::make()
                                            ->schema([
                                                TextInput::make('cota')
                                                    ->label('Cota')
                                                    ->disabled()
                                                    ->dehydrated(),
                                                TextInput::make('book_editorial')
                                                    ->label('Editorial')
                                                    ->disabled()
                                                    ->dehydrated(),
                                            ])->columnSpan(1),
                                        // Hidden fields for data transport
                                        TextInput::make('book_edition')
                                            ->hidden()
                                            ->dehydrated(),
                                    ]),
                            ])
                            ->action(function (array $data, \Filament\Forms\Components\Repeater $component) {
                                // Update status to unavailable
                                $copy = \App\Models\CopyBook::find($data['copy_book_id']);
                                if ($copy) {
                                    $copy->update(['status' => false]);
                                }

                                // Add to repeater
                                $component->getState(); // Ensure state is initialized
                                $uuid = (string) \Illuminate\Support\Str::uuid();
                                $current = $component->getState() ?? [];
                                $current[$uuid] = [
                                    'copy_book_id' => $data['copy_book_id'],
                                    'book_title' => $data['book_title'],
                                    'book_author' => $data['book_author'],
                                    'book_edition' => $data['book_edition'] ?? $copy?->book?->Edition,
                                    'book_editorial' => $data['book_editorial'],
                                    'cover_display' => $copy?->book?->cover,
                                    'cota' => $data['cota'],
                                ];
                                $component->state($current);
                            });
                    })
                    ->deleteAction(function ($action) {
                        return $action->after(function (array $arguments, \Filament\Forms\Components\Repeater $component) {
                             // Arguments contains 'item' which is the UUID key.
                             // Wait, 'after' runs after the state is updated, so the item is gone from state.
                             // We need 'before' to access the item data.
                        })->before(function (array $arguments, \Filament\Forms\Components\Repeater $component) {
                            $state = $component->getState();
                            $uuid = $arguments['item'];
                            $itemData = $state[$uuid] ?? null;

                            if ($itemData && isset($itemData['copy_book_id'])) {
                                $copy = \App\Models\CopyBook::find($itemData['copy_book_id']);
                                if ($copy) {
                                    $copy->update(['status' => true]);
                                }
                            }
                        });
                    })
            ]);
    }
}
