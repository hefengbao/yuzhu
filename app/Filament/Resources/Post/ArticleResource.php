<?php

namespace App\Filament\Resources\Post;

use App\Constant\Commentable;
use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\ArticleResource\Pages;
use App\Filament\Resources\Post\ArticleResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $modelLabel = '文章';

    protected static ?string $pluralModelLabel = '文章';

    protected static ?string $navigationLabel = '文章';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = '写作';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('写作')
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
                                    ->placeholder('开始写作...')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('upload/images/' . date('Ymd'))
                                    ->required(),
                                Forms\Components\CheckboxList::make('categories')
                                    ->label('分类')
                                    ->relationship(
                                        name: 'categories',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn(Builder $query) => $query->orderByDesc('id'),
                                    )
                                    ->required()
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 3,
                                        'lg' => 4,
                                    ])
                                    ->gridDirection('row'),
                                Forms\Components\Select::make('tags')
                                    ->label('标签')
                                    ->multiple()
                                    ->searchable()
                                    ->placeholder('')
                                    ->relationship(name: 'tags', titleAttribute: 'name')
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('名称')
                                            ->placeholder('输入名称')
                                            ->columnSpanFull()
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(
                                                fn(string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state, language: app()->getLocale()))
                                            ),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->columnSpanFull()
                                            ->dehydrated()
                                            ->required(),
                                    ]),
                            ]),

                        Forms\Components\Section::make('SEO')->schema([
                            Forms\Components\Textarea::make('excerpt')
                                ->label('文章摘要')
                                ->maxLength(160),
                        ]),

                        Forms\Components\Section::make('设置')->schema([
                            Forms\Components\Select::make('status')
                                ->label('状态')
                                ->options(PostStatus::class)
                                ->disableOptionWhen(fn(string $value): bool => PostStatus::parse($value) === PostStatus::Rejected)
                                ->default(fn(?Post $record) => $record != null ? $record->status : PostStatus::Draft)
                                ->selectablePlaceholder(false)
                                ->required()
                                ->live()
                                ->hidden(fn(?Post $record) => $record != null && $record->status !== PostStatus::Draft)
                                ->afterStateUpdated(fn($state, Forms\Set $set) => PostStatus::parse($state) === PostStatus::Published ? $set('published_at', Carbon::now()->format('Y-m-d H:i:s')) : null),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('发布时间')
                                ->dehydrated()
                                ->hidden(fn(?Post $record) => $record != null && $record->status !== PostStatus::Draft)
                                ->disabled(fn(Forms\Get $get) => PostStatus::parse($get('status')) == PostStatus::Draft),
                            Forms\Components\Select::make('commentable')
                                ->label('评论设置')
                                ->options(Commentable::class)
                                ->default(Commentable::Open)
                                ->selectablePlaceholder(false)
                                ->required(),
                        ])->columns()
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->prefix(fn(Post $post) => $post->pinned_at != null ? '[置顶]' : '')
                    ->wrap(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('作者'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('分类')
                    ->listWithLineBreaks()
                    ->badge()
                    ->icon('heroicon-o-hashtag')
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('标签')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-tag')
                    ->separator(',')
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->badge()
                    ->description(fn(Post $post) => $post->status == PostStatus::Published ? $post->published_at : ''),
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
                    ->url(fn(Post $record) => route('articles.show', $record->slugId)),
            ])
            ->bulkActions([

            ])
            ->headerActions([

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
                                    Infolists\Components\TextEntry::make('status')
                                        ->label('状态')
                                        ->badge(),
                                    Infolists\Components\TextEntry::make('published_at')
                                        ->label('发布时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info')
                                        ->visible(fn(Post $record) => $record->status === PostStatus::Published),
                                    Infolists\Components\TextEntry::make('categories.name')
                                        ->label('分类')
                                        ->badge()
                                        ->icon('heroicon-o-hashtag'),
                                    Infolists\Components\TextEntry::make('tags.name')
                                        ->label('标签')
                                        ->badge()
                                        ->color('info')
                                        ->icon('heroicon-o-tag'),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
            'view' => Pages\ViewArticle::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User $auth */
        $auth = auth()->user();

        return parent::getEloquentQuery()
            ->where('type', PostType::Article)
            ->when(!$auth->isAdministrator(), function ($query) {
                $query->where(function ($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere(function ($query) {
                            $query->where('user_id', '!=', auth()->id())
                                ->where('status', PostStatus::Published);
                        });
                });
            })
            ->orderByDesc('id');
    }
}
