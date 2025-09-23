<?php

namespace App\Filament\Resources\Post;

use App\Constant\Post\Commentable;
use App\Constant\Post\PostStatus;
use App\Constant\Post\PostType;
use App\Filament\Resources\Post\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\Post\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\Post\ArticleResource\Pages\ListArticles;
use App\Filament\Resources\Post\ArticleResource\Pages\ViewArticle;
use App\Filament\Resources\Post\ArticleResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Locale;

class ArticleResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = '文章';
    protected static ?string $pluralModelLabel = '文章';
    protected static ?string $navigationLabel = '文章';
    protected static ?int $navigationSort = 1;
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?string $slug = 'cms/articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('写作')
                            ->schema([
                                TextInput::make('title')
                                    ->label('标题')
                                    ->placeholder('输入标题')
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
                                MarkdownEditor::make('body')
                                    ->label('内容')
                                    ->placeholder('开始写作...')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('upload/images/' . date('Ymd'))
                                    ->required(),
                                CheckboxList::make('categories')
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
                                Select::make('tags')
                                    ->label('标签')
                                    ->multiple()
                                    ->searchable()
                                    ->placeholder('')
                                    ->relationship(name: 'tags', titleAttribute: 'name')
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('名称')
                                            ->placeholder('输入名称')
                                            ->columnSpanFull()
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(
                                                fn(string $operation, $state, Set $set) => $set('slug', Str::slug($state, language: app()->getLocale()))
                                            ),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->columnSpanFull()
                                            ->dehydrated()
                                            ->required(),
                                    ]),
                            ]),

                        Section::make('SEO')->schema([
                            Textarea::make('excerpt')
                                ->label('文章摘要')
                                ->maxLength(160),
                        ]),

                        Section::make('设置')->schema([
                            Select::make('status')
                                ->label('状态')
                                ->options(PostStatus::class)
                                ->disableOptionWhen(fn(string $value): bool => PostStatus::parse($value) === PostStatus::Rejected)
                                ->default(fn(?Post $record) => $record != null ? $record->status : PostStatus::Draft)
                                ->selectablePlaceholder(false)
                                ->required()
                                ->live()
                                ->hidden(fn(?Post $record) => $record != null && $record->status !== PostStatus::Draft)
                                ->afterStateUpdated(fn($state, Set $set) => PostStatus::parse($state) === PostStatus::Published ? $set('published_at', Carbon::now()->format('Y-m-d H:i:s')) : null),
                            DateTimePicker::make('published_at')
                                ->label('发布时间')
                                ->dehydrated()
                                ->hidden(fn(?Post $record) => $record != null && $record->status !== PostStatus::Draft)
                                ->disabled(fn(Get $get) => PostStatus::parse($get('status')) == PostStatus::Draft),
                            Select::make('commentable')
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
                TextColumn::make('title')
                    ->label('标题')
                    ->prefix(fn(Post $post) => $post->pinned_at != null ? '[置顶]' : '')
                    ->wrap()
                    ->searchable(['title', 'excerpt'])
                    ->description(fn(Post $post) => $post->excerpt),
                TextColumn::make('author.name')
                    ->label('作者'),
                TextColumn::make('categories.name')
                    ->label('分类')
                    ->listWithLineBreaks()
                    ->badge()
                    ->icon('heroicon-o-hashtag')
                    ->visibleFrom('md'),
                TextColumn::make('tags.name')
                    ->label('标签')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-tag')
                    ->separator(',')
                    ->visibleFrom('md'),
                TextColumn::make('status')
                    ->label('状态')
                    ->badge()
                    ->description(fn(Post $post) => $post->status == PostStatus::Published ? $post->published_at : ''),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('visit')
                    ->icon('heroicon-o-globe-alt')
                    ->label('访问')
                    ->color('info')
                    ->url(fn(Post $record) => route('articles.show', $record->slugId), true),
            ])
            ->toolbarActions([

            ])
            ->headerActions([

            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('title')
                                        ->label('标题'),
                                    TextEntry::make('slug')
                                        ->label('Slug'),
                                    TextEntry::make('author.name')->label('作者'),
                                ]),
                                Group::make([
                                    TextEntry::make('status')
                                        ->label('状态')
                                        ->badge(),
                                    TextEntry::make('published_at')
                                        ->label('发布时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info')
                                        ->visible(fn(Post $record) => $record->status === PostStatus::Published),
                                    TextEntry::make('categories.name')
                                        ->label('分类')
                                        ->badge()
                                        ->icon('heroicon-o-hashtag'),
                                    TextEntry::make('tags.name')
                                        ->label('标签')
                                        ->badge()
                                        ->color('info')
                                        ->icon('heroicon-o-tag'),
                                ]),
                            ]),
                    ]),
                Section::make('摘要')->schema([
                    TextEntry::make('excerpt')
                        ->hiddenLabel(),
                ]),
                Section::make('内容')->schema([
                    TextEntry::make('body')
                        ->prose()
                        ->markdown()
                        ->hiddenLabel(),
                ])->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
            'view' => ViewArticle::route('/{record}'),
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
