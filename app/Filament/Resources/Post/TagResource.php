<?php

namespace App\Filament\Resources\Post;

use App\Filament\Resources\Post\TagResource\Pages\CreateTag;
use App\Filament\Resources\Post\TagResource\Pages\EditTag;
use App\Filament\Resources\Post\TagResource\Pages\ListTags;
use App\Models\Tag;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Locale;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $modelLabel = '标签';
    protected static ?string $pluralModelLabel = '标签';
    protected static ?string $navigationLabel = '标签';
    protected static ?int $navigationSort = 6;
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?string $slug = 'cms/tags';

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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
