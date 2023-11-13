<?php

namespace App\Filament\Resources\Post;

use App\Filament\Resources\Post\PageResource\Pages;
use App\Filament\Resources\Post\PageResource\Pages\CreatePage;
use App\Filament\Resources\Post\PageResource\Pages\EditPage;
use App\Filament\Resources\Post\PageResource\Pages\ListPages;
use App\Filament\Resources\Post\PageResource\RelationManagers;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = "页面";
    protected static ?string $pluralModelLabel = "页面";
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = "页面";
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = '写作';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
