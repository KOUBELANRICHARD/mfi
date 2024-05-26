<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'accounts';

    public function form(Form $form): Form
    {
        $user_id = Auth::id();
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(Account::TYPES)
                    ->required(),
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
            ->recordTitleAttribute('account_number')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('type')
                    ->label('Type')
                    ->disabled()
                    ->options(Account::TYPES)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Créé par'),
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
                Action::make('Attestation de solde')
                    ->url(fn(Account $record) => route('accounts.certificate', $record))
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-arrow-down-tray'),
                Action::make('Relevé de compte')
                    ->form([
                        Forms\Components\Datepicker::make('start')
                            ->label('Date de début')
                            ->required(),
                        Forms\Components\Datepicker::make('end')
                            ->label('Date de fin')
                            ->required(),
                    ])
                    ->icon('heroicon-m-document-arrow-down')
                    ->action(function (array $data, Account $record) {
                        session()->flash('data', $data);
                        return redirect()->route('accounts.statement', $record);
                    }),
                Tables\Actions\EditAction::make()->label('Modifier'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
