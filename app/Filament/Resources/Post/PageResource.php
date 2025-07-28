<?php

namespace App\Filament\Resources\Post;

use App\Constant\Post\Commentable;
use App\Constant\Post\PostStatus;
use App\Constant\Post\PostType;
use App\Filament\Resources\Post\PageResource\Pages;
use App\Filament\Resources\Post\PageResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = '页面';
    protected static ?string $pluralModelLabel = '页面';
    protected static ?string $navigationLabel = '页面';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = '内容';
    protected static ?string $slug = 'cms';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('标题')
                    ->placeholder('输入标题')
                    ->columnSpanFull()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state, language: \Locale::getDefault())) : null
                    ),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->columnSpanFull()
                    ->dehydrated()
                    ->required(),
                Forms\Components\MarkdownEditor::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('commentable')
                    ->label('评论设置')
                    ->options(Commentable::class)
                    ->default(Commentable::Closed)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('标题'),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('发布时间')
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('visit')
                    ->icon('heroicon-o-globe-alt')
                    ->label('访问')
                    ->color('info')
                    ->url(fn(Post $record) => route('pages.show', $record->slugId), true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\Group::make([
                                    Infolists\Components\TextEntry::make('title')
                                        ->label('标题'),
                                    Infolists\Components\TextEntry::make('slug')
                                        ->label('Slug'),
                                    Infolists\Components\TextEntry::make('author.name')->label('作者'),
                                ]),
                                Infolists\Components\Group::make([
                                    Infolists\Components\TextEntry::make('commentable')
                                        ->label('是否开启评论')
                                        ->badge()
                                        ->color(fn(Commentable $state): string => match ($state) {
                                            Commentable::Open => 'success',
                                            Commentable::Closed => 'danger',
                                        }),
                                    Infolists\Components\TextEntry::make('published_at')
                                        ->label('发布时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info'),
                                ]),
                            ]),
                    ]),
                Infolists\Components\Section::make('摘要')->schema([
                    Infolists\Components\TextEntry::make('excerpt')
                        ->hiddenLabel(),
                ]),
                Infolists\Components\Section::make('内容')->schema([
                    Infolists\Components\TextEntry::make('body')
                        ->prose()
                        ->markdown()
                        ->hiddenLabel(),
                ])->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
            'view' => Pages\ViewPage::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User $auth */
        $auth = auth()->user();

        return parent::getEloquentQuery()
            ->where('type', PostType::Page)
            ->when(!$auth->isAdministrator(), function ($query) {
                $query->where('status', PostStatus::Published);
            })
            ->orderByDesc('id');
    }
}
