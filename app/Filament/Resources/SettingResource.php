<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Website Setting';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Settings')->tabs([
                Forms\Components\Tabs\Tab::make('Company')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('company_name')->required(),
                        Forms\Components\TextInput::make('tagline'),
                        Forms\Components\TextInput::make('established_year'),
                        Forms\Components\Toggle::make('iso_certified'),
                    ]),
                    Forms\Components\FileUpload::make('logo')->image()->maxSize(5120)->imageResizeTargetWidth(300)->imageResizeMode('contain')->directory('settings'),
                    Forms\Components\FileUpload::make('favicon')->image()->maxSize(5120)->imageResizeTargetWidth(64)->imageResizeMode('contain')->directory('settings'),
                    Forms\Components\TextInput::make('logo_width')->numeric()->default(180),
                    Forms\Components\TextInput::make('logo_height')->numeric()->default(null)->helperText('Leave empty for auto-height'),
                ]),
                Forms\Components\Tabs\Tab::make('Contact Information')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('email')->email(),
                        Forms\Components\TextInput::make('phone_primary')->label('Primary Phone'),
                        Forms\Components\TextInput::make('phone_secondary')->label('Secondary Phone'),
                        Forms\Components\TextInput::make('phone_office')->label('Office Phone'),
                        Forms\Components\TextInput::make('whatsapp'),
                    ]),
                    Forms\Components\Textarea::make('address')->rows(2),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('city'),
                        Forms\Components\TextInput::make('state'),
                        Forms\Components\TextInput::make('pincode'),
                    ]),
                    Forms\Components\Textarea::make('map_embed')->label('Google Maps Embed URL')->rows(2),
                ]),
                Forms\Components\Tabs\Tab::make('Social Media')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('facebook')->url(),
                        Forms\Components\TextInput::make('twitter')->url(),
                        Forms\Components\TextInput::make('instagram')->url(),
                        Forms\Components\TextInput::make('linkedin')->url(),
                        Forms\Components\TextInput::make('youtube')->url(),
                    ]),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone_primary'),
                Tables\Columns\ImageColumn::make('logo_url')->label('Logo'),
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
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
