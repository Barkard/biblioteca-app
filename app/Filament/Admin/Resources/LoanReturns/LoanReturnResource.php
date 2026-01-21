<?php

namespace App\Filament\Admin\Resources\LoanReturns;

use App\Filament\Admin\Resources\LoanReturns\Pages\CreateLoanReturn;
use App\Filament\Admin\Resources\LoanReturns\Pages\EditLoanReturn;
use App\Filament\Admin\Resources\LoanReturns\Pages\ListLoanReturns;
use App\Filament\Admin\Resources\LoanReturns\Schemas\LoanReturnForm;
use App\Filament\Admin\Resources\LoanReturns\Tables\LoanReturnsTable;
use App\Models\LoanReturn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanReturnResource extends Resource
{
    protected static ?string $model = LoanReturn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Préstamo/Devolución';
    protected static ?string $pluralModelLabel = 'Préstamos y Devoluciones';
    protected static ?string $navigationLabel = 'Préstamos';

    protected static ?string $recordTitleAttribute = 'id';

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\TextEntry::make('user.name')
                    ->label('Usuario Solicitante')
                    ->formatStateUsing(fn ($record) => $record->user->name . ' ' . $record->user->last_name),
                \Filament\Infolists\Components\TextEntry::make('created_at')
                    ->label('Fecha de Préstamo')
                    ->date(),
                \Filament\Infolists\Components\RepeatableEntry::make('loanDetails')
                    ->label('Ejemplares Solicitados')
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(3)
                            ->schema([
                                \Filament\Schemas\Components\Group::make([
                                    \Filament\Schemas\Components\Grid::make(2)
                                        ->schema([
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.book.title')
                                                ->label('Libro')
                                                ->columnSpan(2),
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.book.author.name')
                                                ->label('Autor'),
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.book.Edition')
                                                ->label('Edición'),
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.book.publisher.name')
                                                ->label('Editorial'),
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.cota')
                                                ->label('Cota'),
                                            \Filament\Infolists\Components\TextEntry::make('copyBook.book.synopsis')
                                                ->label('Descripción')
                                                ->columnSpanFull()
                                                ->html() // Assume synopsis might be rich text or long
                                                ->limit(200),
                                            \Filament\Infolists\Components\TextEntry::make('return_date')
                                                ->label('Fecha de Devolución')
                                                ->placeholder('Pendiente')
                                                ->columnSpanFull(),
                                        ]),
                                     \Filament\Actions\Action::make('devolver')
                                        ->label('Devolver libro')
                                        ->icon('heroicon-o-arrow-path')
                                        ->color('success')
                                        ->requiresConfirmation()
                                        ->visible(fn ($record) => $record->return_date === null)
                                        ->action(function ($record) {
                                            $record->update(['return_date' => now()]);
                                            if ($record->copyBook) {
                                                $record->copyBook->update(['status' => true]);
                                            }

                                            // Check if all items in this loan have been returned
                                            $loanReturn = $record->loanReturn;
                                            $pendingItems = $loanReturn->loanDetails()->whereNull('return_date')->count();

                                            if ($pendingItems === 0) {
                                                $loanReturn->update(['status' => false]);
                                            }

                                            \Filament\Notifications\Notification::make()
                                                ->title('Ejemplar devuelto')
                                                ->success()
                                                ->send();
                                        })
                                ])->columnSpan(2),

                                \Filament\Infolists\Components\ImageEntry::make('copyBook.book.cover')
                                    ->label('Portada')
                                    ->height('100%')
                                    ->width('100%')
                                    ->columnSpan(1)
                                    ->extraImgAttributes(['style' => 'object-fit: contain; max-height: 300px;']),
                            ]),
                    ])
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return LoanReturnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanReturnsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoanReturns::route('/'),
            'create' => CreateLoanReturn::route('/create'),
            'edit' => EditLoanReturn::route('/{record}/edit'),
        ];
    }
}
