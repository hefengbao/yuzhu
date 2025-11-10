<?php

namespace App\Filament\Resources\CMS;

use App\Enums\CMS\Commentable;
use App\Enums\CMS\PostStatus;
use App\Enums\CMS\PostType;
use App\Filament\Resources\CMS\TweetResource\Pages\CreateTweet;
use App\Filament\Resources\CMS\TweetResource\Pages\EditTweet;
use App\Filament\Resources\CMS\TweetResource\Pages\ListTweets;
use App\Filament\Resources\CMS\TweetResource\Pages\ViewTweet;
use App\Filament\Resources\CMS\TweetResource\RelationManagers\CommentsRelationManager;
use App\Models\CMS\Post;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Locale;

class TweetResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = '微博';
    protected static ?string $pluralModelLabel = '微博';
    protected static ?string $navigationLabel = '微博';
    protected static ?int $navigationSort = 2;
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?string $slug = 'cms/tweets';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('body')
                    ->hiddenLabel()
                    ->placeholder('想要分享什么？')
                    ->disableAllToolbarButtons()
                    ->required()
                    ->columnSpanFull(),
                Select::make('commentable')
                    ->label('评论设置')
                    ->options(Commentable::class)
                    ->default(Commentable::Open)
                    ->required(),
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
                                fn(string $operation, $state, Set $set) => $set('slug', Str::slug($state, language: Locale::getDefault()))
                            ),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->columnSpanFull()
                            ->dehydrated()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author.name')
                    ->label('作者'),
                TextColumn::make('body')
                    ->label('内容')
                    ->alignLeft()
                    ->wrap()
                    ->searchable(),
                TextColumn::make('tags.name')
                    ->label('标签')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('发布时间')
                    ->dateTime('Y-m-d H:i:s'),
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
                    ->url(fn(Post $record) => route('tweets.show', $record->slugId), true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextEntry::make('author.name')
                                        ->label('用户名'),
                                    TextEntry::make('created_at')
                                        ->label('发表时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info'),
                                ]),
                            Group::make()->schema([
                                TextEntry::make('tags.name')
                                    ->label('标签')
                                    ->badge(),
                            ]),
                        ]),
                ]),
            Section::make('内容')->schema([
                TextEntry::make('body')
                    ->hiddenLabel()
                    ->markdown(),
            ]),
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
            'index' => ListTweets::route('/'),
            'create' => CreateTweet::route('/create'),
            'edit' => EditTweet::route('/{record}/edit'),
            'view' => ViewTweet::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User $auth */
        $auth = auth()->user();

        return parent::getEloquentQuery()
            ->where('type', PostType::Tweet)
            ->when(!$auth->isAdministrator(), function ($query) {
                $query->where(function ($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere(function ($query) {
                            $query->where('user_id', '!=', auth()->id())
                                ->where('status', PostStatus::Published);
                        });
                });
            })
            ->orderByDesc('created_at');
    }
}
