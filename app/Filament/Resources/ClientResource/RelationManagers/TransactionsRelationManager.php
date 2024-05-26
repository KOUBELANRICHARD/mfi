<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Agency;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Libellé')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('value_date')
                    ->label('Date de valeur')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
