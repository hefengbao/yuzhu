<?php

namespace App\Filament\Resources\Post;

use App\Constant\Commentable;
use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\TweetResource\Pages;
use App\Filament\Resources\Post\TweetResource\RelationManagers;
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

class TweetResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $modelLabel = '微博';

    protected static ?string $pluralModelLabel = '微博';

    protected static ?string $navigationLabel = '微博';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = '写作';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('body')
                    ->hiddenLabel()
                    ->placeholder('想要分享什么？')
                    ->disableAllToolbarButtons()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('commentable')
                    ->label('评论设置')
                    ->options(Commentable::class)
                    ->default(Commentable::Open)
                    ->required(),
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
                                fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state, language: \Locale::getDefault()))
                            ),
                        Forms\Components\TextInput::make('slug')
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
                Tables\Columns\TextColumn::make('body')
                    ->label('内容')
                    ->markdown()
                    ->wrap(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('作者'),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('标签')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make()
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\Group::make()
                                ->schema([
                                    Infolists\Components\TextEntry::make('author.name')
                                        ->label('用户名'),
                                    Infolists\Components\TextEntry::make('created_at')
                                        ->label('发表时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info'),
                                ]),
                            Infolists\Components\Group::make()->schema([
                                Infolists\Components\TextEntry::make('tags.name')
                                    ->label('标签')
                                    ->badge(),
                            ]),
                        ]),
                ]),
            Infolists\Components\Section::make('内容')->schema([
                Infolists\Components\TextEntry::make('body')
                    ->hiddenLabel()
                    ->markdown(),
            ]),
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
            'index' => Pages\ListTweets::route('/'),
            'create' => Pages\CreateTweet::route('/create'),
            'edit' => Pages\EditTweet::route('/{record}/edit'),
            'view' => Pages\ViewTweet::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User $auth */
        $auth = auth()->user();

        return parent::getEloquentQuery()
            ->where('type', PostType::Tweet)
            ->when(! $auth->isAdministrator(), function ($query) {
                $query->where(function ($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere(function ($query) {
                            $query->where('user_id', '!=', auth()->id())
                                ->where('status', PostStatus::Publish);
                        });
                });
            })
            ->orderByDesc('created_at');
    }
}
