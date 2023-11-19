<?php

namespace App\Filament\Resources\Post;

use App\Filament\Resources\Post\CategoryResource\Pages;
use App\Filament\Resources\Post\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = "分类";
    protected static ?string $pluralModelLabel = "分类";

    //protected static ?string $navigationIcon = 'heroicon-o-hashtag';
    protected static ?string $navigationLabel = "分类";
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = '写作';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('名称')
                    ->placeholder('输入名称')
                    ->columnSpanFull()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state, language: \Locale::getDefault())) : null
                    ),
                TextInput::make('slug')
                    ->label('Slug')
                    ->columnSpanFull()
                    ->dehydrated()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('名称'),
                Tables\Columns\TextColumn::make('slug')->label('slug'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
