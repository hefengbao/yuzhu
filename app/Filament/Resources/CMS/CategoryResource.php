<?php

namespace App\Filament\Resources\CMS;

use App\Filament\Resources\CMS\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CMS\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CMS\CategoryResource\Pages\ListCategories;
use App\Models\CMS\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Locale;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = '分类';
    protected static ?string $pluralModelLabel = '分类';
    protected static ?string $navigationLabel = '分类';
    protected static ?int $navigationSort = 5;
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?string $slug = 'cms/categories';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator() || auth()->user()->isEditor();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('名称')
                    ->placeholder('输入名称')
                    ->columnSpanFull()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state, language: Locale::getDefault())) : null
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
                TextColumn::make('name')->label('名称'),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('created_at')->label('创建时间'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderByDesc('id');
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
