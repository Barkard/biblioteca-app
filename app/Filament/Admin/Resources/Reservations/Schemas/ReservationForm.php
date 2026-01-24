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
                DatePicker::make('reservation_date')
                    ->label('Fecha de Reserva')
                    ->required(),
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
                    ->schema([
                        Select::make('book_id')
                            ->label('Libro')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return \App\Models\Book::query()
                                    ->where('title', 'like', "%{$search}%")
                                    ->orWhereHas('copyBooks', function ($query) use ($search) {
                                        $query->where('cota', 'like', "%{$search}%");
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
                            ->afterStateUpdated(fn (Set $set) => $set('copy_book_id', null))
                            ->required(),
                        Select::make('copy_book_id')
                            ->label('Ejemplar (Cota)')
                            ->options(function (Get $get) {
                                $bookId = $get('book_id');
                                if (! $bookId) {
                                    return [];
                                }

                                return \App\Models\CopyBook::query()
                                    ->where('book_id', $bookId)
                                    ->get()
                                    ->mapWithKeys(function ($copy) {
                                        $label = $copy->cota;
                                        if (! $copy->status) {
                                            $date = $copy->nextAvailableDate();
                                            $label .= " (Ocupado" . ($date ? " hasta {$date}" : "") . ")";
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
                                if (! $copy || $copy->status) return null;

                                $date = $copy->nextAvailableDate();
                                if (! $date) return null;

                                $carbonDate = \Carbon\Carbon::parse($date);
                                $days = \Carbon\Carbon::now()->diffInDays($carbonDate, false);

                                if ($days >= 5) {
                                    return new \Illuminate\Support\HtmlString("<span style='color: red; font-weight: bold;'>Faltan {$days} días para que el libro esté disponible</span>");
                                }

                                if ($days >= 0) {
                                    return new \Illuminate\Support\HtmlString("<span style='color: yellow; font-weight: bold;'>Faltan {$days} días para que el libro esté disponible</span> (Se marcará como <span style='color: orange;'>PENDIENTE</span>)");
                                }

                                return null;
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
                                        $days = \Carbon\Carbon::now()->diffInDays($carbonDate, false);

                                        if ($days >= 5) {
                                            $fail("Faltan {$days} días para que el libro esté disponible. No se puede realizar la reserva.");
                                        }
                                    };
                                },
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
