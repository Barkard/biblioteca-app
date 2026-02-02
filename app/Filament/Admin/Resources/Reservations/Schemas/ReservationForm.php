<?php

namespace App\Filament\Admin\Resources\Reservations\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                \Filament\Forms\Components\Repeater::make('reservationDetails')
                    ->relationship('reservationDetails')
                    ->addAction(fn ($action) => $action->after(fn ($livewire) => $livewire->resetValidation()))
                    ->schema([
                        Select::make('book_id')
                            ->label('Libro')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return \App\Models\Book::query()
                                    ->where('title', 'ilike', "%{$search}%")
                                    ->orWhereHas('copyBooks', function ($query) use ($search) {
                                        $query->where('cota', 'ilike', "%{$search}%");
                                    })
                                    ->withCount(['copyBooks as available_copies_count' => function ($query) {
                                        $query->where('status', true);
                                    }])
                                    ->get()
                                    ->mapWithKeys(fn ($book) => [$book->id => "{$book->title} ({$book->available_copies_count} disponibles)"]);
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $book = \App\Models\Book::query()
                                    ->withCount(['copyBooks as available_copies_count' => function ($query) {
                                        $query->where('status', true);
                                    }])
                                    ->find($value);

                                return $book ? "{$book->title} ({$book->available_copies_count} disponibles)" : null;
                            })
                            ->live()
                            ->hint(function (Get $get) {
                                $bookId = $get('book_id');
                                if (!$bookId) return null;

                                $book = \App\Models\Book::find($bookId);
                                if (!$book) return null;

                                $availableNow = $book->copyBooks()->where('status', true)->exists();
                                if ($availableNow) {
                                    return new \Illuminate\Support\HtmlString("<span style='color: #0ce23aff !important; font-weight: bold;'>¡Disponible ahora!</span>");
                                }

                                // Find valid copies for reservation (within 5 days)
                                $reservableCopies = $book->copyBooks()
                                    ->get()
                                    ->filter(function($copy) {
                                        $date = $copy->nextAvailableDate();
                                        if (!$date) return false;
                                        return \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($date)->startOfDay(), false) < 5;
                                    })
                                    ->sortBy(fn($copy) => $copy->nextAvailableDate());

                                if ($reservableCopies->isNotEmpty()) {
                                    $earliestCopy = $reservableCopies->first();
                                    $date = $earliestCopy->nextAvailableDate();
                                    $days = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($date)->startOfDay(), false);
                                    return new \Illuminate\Support\HtmlString("<span style='color: #f7d02c !important; font-weight: bold;'>Ocupado. Reservable (vuelve en aprox. {$days} días)</span>");
                                }

                                // Check if there are any copies at all that will be available later
                                $earliestAny = $book->copyBooks()
                                    ->get()
                                    ->sortBy(fn($copy) => $copy->nextAvailableDate())
                                    ->first();

                                if ($earliestAny) {
                                    $date = $earliestAny->nextAvailableDate();
                                    $days = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($date)->startOfDay(), false);
                                    return new \Illuminate\Support\HtmlString("<span style='color: #ef4444 !important; font-weight: bold;'>Ocupado. NO reservable (Disponible en {$days} días)</span>");
                                }

                                return null;
                            })
                            ->afterStateUpdated(fn (Set $set) => $set('copy_book_id', null))
                            ->required(),
                        Select::make('copy_book_id')
                            ->label('Ejemplar (Cota)')
                            ->options(function (Get $get, Select $component) {
                                $bookId = $get('book_id');
                                if (! $bookId) {
                                    return [];
                                }

                                // Get all selected copy IDs in the repeater
                                $selectedCopies = collect($get('../../reservationDetails'))
                                    ->pluck('copy_book_id')
                                    ->filter(fn ($id) => $id && (string)$id !== (string)$component->getState())
                                    ->values();

                                return \App\Models\CopyBook::query()
                                    ->where('book_id', $bookId)
                                    ->whereNotIn('id', $selectedCopies)
                                    ->get()
                                    ->mapWithKeys(function ($copy) {
                                        $label = $copy->cota;
                                        if ($copy->status) {
                                            $label .= " (Disponible)";
                                        } else {
                                            $date = $copy->nextAvailableDate();
                                            if ($date) {
                                                $days = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($date)->startOfDay(), false);
                                                $label .= " (Ocupado - Faltan {$days} días)";
                                            } else {
                                                $label .= " (Ocupado)";
                                            }
                                        }
                                        return [$copy->id => $label];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->hint(function (Get $get) {
                                $copyId = $get('copy_book_id');
                                if (! $copyId) return null;

                                $copy = \App\Models\CopyBook::find($copyId);
                                if (! $copy) return null;

                                if ($copy->status) {
                                    return new \Illuminate\Support\HtmlString("<span style='color: #0ce23aff !important; font-weight: bold;'>¡Disponible ahora!</span>");
                                }

                                $date = $copy->nextAvailableDate();
                                if (! $date) return null;

                                $carbonDate = \Carbon\Carbon::parse($date);
                                $days = \Carbon\Carbon::now()->startOfDay()->diffInDays($carbonDate->startOfDay(), false);

                                if ($days >= 5) {
                                    return new \Illuminate\Support\HtmlString("<span style='color: #ef4444 !important; font-weight: bold;'>NO RESERVABLE: Faltan {$days} días</span>");
                                }

                                return new \Illuminate\Support\HtmlString("<span style='color: #f7d02c !important; font-weight: bold;'>RESERVABLE: Faltan {$days} días</span> (Reserva PENDIENTE)");
                            })
                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                                        if (!$value) return;

                                        $copy = \App\Models\CopyBook::find($value);
                                        if (!$copy || $copy->status) return;

                                        $date = $copy->nextAvailableDate();
                                        if (!$date) return;

                                        $carbonDate = \Carbon\Carbon::parse($date);
                                        $days = \Carbon\Carbon::now()->startOfDay()->diffInDays($carbonDate->startOfDay(), false);

                                        if ($days >= 5) {
                                            $fail("este ejemplar no se puede reservar");
                                        }
                                    };
                                },
                            ])
                            ->validationMessages([
                                'required' => 'Debes seleccionar un ejemplar.',
                                'in' => 'este ejemplar no se puede reservar',
                            ])
                            ->hidden(fn (Get $get) => ! $get('book_id'))
                            ->required(),

                    ])
                    ->label('Detalles de la Reserva')
                    ->columnSpanFull()
                    ->grid(2),
                ]);
    }
}
