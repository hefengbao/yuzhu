<?php

namespace App\Filament\Resources\Post;

use App\Filament\Resources\Post\TweetResource\Pages;
use App\Filament\Resources\Post\TweetResource\Pages\CreateTweet;
use App\Filament\Resources\Post\TweetResource\Pages\EditTweet;
use App\Filament\Resources\Post\TweetResource\Pages\ListTweets;
use App\Filament\Resources\Post\TweetResource\RelationManagers;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TweetResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = "微博";
    protected static ?string $pluralModelLabel = "微博";
    protected static ?string $navigationIcon = 'heroicon-o-fire';
    protected static ?string $navigationLabel = "微博";
    protected static ?int $navigationSort = 2;
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
            'index' => ListTweets::route('/'),
            'create' => CreateTweet::route('/create'),
            'edit' => EditTweet::route('/{record}/edit'),
        ];
    }
}
