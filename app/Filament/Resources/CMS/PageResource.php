<?php

namespace App\Filament\Resources\CMS;

use App\Constant\CMS\Commentable;
use App\Constant\CMS\PostStatus;
use App\Constant\CMS\PostType;
use App\Filament\Resources\CMS\PageResource\Pages\CreatePage;
use App\Filament\Resources\CMS\PageResource\Pages\EditPage;
use App\Filament\Resources\CMS\PageResource\Pages\ListPages;
use App\Filament\Resources\CMS\PageResource\Pages\ViewPage;
use App\Filament\Resources\CMS\PageResource\RelationManagers\CommentsRelationManager;
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

class PageResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $modelLabel = '页面';
    protected static ?string $pluralModelLabel = '页面';
    protected static ?string $navigationLabel = '页面';
    protected static ?int $navigationSort = 3;
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?string $slug = 'cms/pages';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->required()
                    ->columnSpanFull(),
                Select::make('commentable')
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
                TextColumn::make('title')
                    ->label('标题'),
                TextColumn::make('status')
                    ->label('状态')
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
                    ->url(fn(Post $record) => route('pages.show', $record->slugId), true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
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
                                    TextEntry::make('commentable')
                                        ->label('是否开启评论')
                                        ->badge()
                                        ->color(fn(Commentable $state): string => match ($state) {
                                            Commentable::Open => 'success',
                                            Commentable::Closed => 'danger',
                                        }),
                                    TextEntry::make('published_at')
                                        ->label('发布时间')
                                        ->badge()
                                        ->dateTime()
                                        ->color('info'),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
            'view' => ViewPage::route('/{record}'),
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
