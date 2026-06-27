<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceBrochureResource\Pages;
use App\Models\ServiceBrochure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceBrochureResource extends Resource
{
    protected static ?string $model = ServiceBrochure::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationGroup = 'Services';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('service_id')->relationship('service', 'title')->required(),
            Forms\Components\TextInput::make('brochure_name')->maxLength(255),
            Forms\Components\FileUpload::make('brochure_file')->acceptedFileTypes(['application/pdf'])->maxSize(10240)->directory('brochures'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.title'),
                Tables\Columns\TextColumn::make('brochure_name'),
                Tables\Columns\TextColumn::make('brochure_file')->url(fn ($record) => asset('storage/' . $record->brochure_file))->openUrlInNewTab(),
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
            'index' => Pages\ManageServiceBrochures::route('/'),
        ];
    }
}
