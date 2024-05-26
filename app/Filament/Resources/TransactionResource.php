<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Agency;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationLabel = 'Transactions';
    protected static ?string $modelLabel = 'Transaction';
    protected static ?string $navigationGroup = 'Clientèles';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';



    public static function form(Form $form): Form
    {
        $user_id = Auth::id();
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Forms\Components\Select::make('type')
                    ->options(Transaction::TYPES)
                    ->required(),
                Forms\Components\Datepicker::make('value_date')
                    ->required(),
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'account_number')
                    ->required(),
                Select::make('agency_id')
                    ->required()
                    ->label('Agence')
                    ->options(Agency::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('created_by')
                    ->disabled()
                    ->default($user_id)
                    ->relationship('user', 'name')
                    ->label('Créé par')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.client.name')
                    ->label('Client')
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.account_number')
                    ->label('Compte')
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency.name')
                    ->label('Agence')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Créé par')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value_date')
                    ->label('Date de valeur')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')
                    ->label('Libellé')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc') ->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
