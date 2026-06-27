<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SisterConcernResource\Pages;
use App\Models\SisterConcern;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SisterConcernResource extends Resource
{
    protected static ?string $model = SisterConcern::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('company_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('website_link')->url(),
                Forms\Components\TextInput::make('contact_phone'),
                Forms\Components\TextInput::make('contact_email')->email(),
            ]),
            Forms\Components\FileUpload::make('logo')->image()->maxSize(2048)->imageResizeTargetWidth(300)->directory('sister-concerns'),
            Forms\Components\Textarea::make('description')->rows(3),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('status')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->searchable(),
                Tables\Columns\TextColumn::make('website_link'),
                Tables\Columns\TextColumn::make('contact_phone'),
                Tables\Columns\IconColumn::make('status')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSisterConcerns::route('/'),
        ];
    }
}
