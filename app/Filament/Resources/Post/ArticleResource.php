<?php

namespace App\Filament\Resources\Post;

use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\ArticleResource\Pages;
use App\Filament\Resources\Post\ArticleResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = "文章";
    protected static ?string $pluralModelLabel = "文章";

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = "文章";
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = '写作';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->label('标题')
                                    ->placeholder('输入标题')
                                    ->columnSpanFull()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(
                                        fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state, language: \Locale::getDefault())) : null
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
                                    ->fileAttachmentsDirectory('upload/images/'. date('Ymd'))
                                    ->required(),
                                /*Forms\Components\Select::make('categories')
                                    ->label('分类')
                                    ->placeholder('请选择分类')
                                    ->multiple()
                                    ->searchable()
                                    ->relationship(name:'categories',titleAttribute: 'name')
                                    ->preload()
                                    ->required(),*/
                                Forms\Components\CheckboxList::make('categories')
                                    ->label('分类')
                                    ->relationship(
                                        name:'categories',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->orderByDesc('id'),
                                    )
                                    ->required()
                                    ->columns(2)
                                    ->gridDirection('row'),
                                Forms\Components\Select::make('tags')
                                    ->label('标签')
                                    ->multiple()
                                    ->searchable()
                                    ->placeholder('')
                                    ->relationship(name:'tags',titleAttribute: 'name')
                                    ->preload(),
                                Forms\Components\Select::make('status')
                                    ->label('状态')
                                    ->options([
                                        PostStatus::Draft->value => '草稿',
                                        PostStatus::Publish->value => '发布',
                                        PostStatus::Future->value => '定时发布',
                                    ])
                                    ->default(PostStatus::Draft->value)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $state !== PostStatus::Future->value ? $set('published_at', null) : null),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('发布时间')
                                    ->dehydrated()
                                    ->disabled(fn (Forms\Get $get) => $get('status') !== PostStatus::Future->value),
                            ])
                        ->columns(2)
                    ])
                    ->columnSpan(['lg' => fn (?Post $record) => $record === null ? 3 : 2]),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('标题')
                    ->formatStateUsing(fn(Post $post) => $post->pinned_at != null ? "[置顶] $post->title" : $post->title),
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
                    ->color(fn(PostStatus $state): string => match ($state){
                        PostStatus::Draft => 'primary',
                        PostStatus::Future => 'info',
                        PostStatus::Publish => 'success',
                        PostStatus::Pending => 'warning',
                        default => 'danger'
                    }),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
            'view' => Pages\ViewArticle::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', PostType::Article)->orderByDesc('created_at');
    }
}
