<?php

namespace App\Filament\Clusters\CMS\Comment\Resources;

use App\Constant\CMS\CommentStatus;
use App\Constant\CMS\PostType;
use App\Filament\Clusters\CMS\Comment\Resources\ApprovedResource\Pages\EditComment;
use App\Filament\Clusters\CMS\Comment\Resources\ApprovedResource\Pages\ListComments;
use App\Filament\Clusters\CMS\Comment\Resources\ApprovedResource\Pages\ViewComment;
use App\Models\CMS\Comment;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApprovedResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $modelLabel = '已发布';
    protected static ?string $pluralModelLabel = '已发布';
    protected static ?string $cluster = \App\Filament\Clusters\CMS\Comment::class;
    protected static ?string $slug = 'approved';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('状态')
                    ->options(CommentStatus::class)
                    ->default(CommentStatus::Approved)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name')
                    ->label('作者')
                    ->description(fn(Comment $record) => $record->user_email),
                TextColumn::make('ip')->label('IP'),
                TextColumn::make('body')
                    ->label('内容')
                    ->wrap()
                    ->description(fn(?Comment $record): string => $record?->parent != null ? '引用：' . $record->parent->body : ''),
                TextColumn::make('status')
                    ->label('状态')->badge()
                    ->description(fn(Comment $record) => $record->created_at->format('Y-m-d H:i:s')),
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
                    ->url(
                        function (Comment $record) {
                            $post = $record->post;

                            return match ($post->type) {
                                PostType::Article => route('articles.show', slug_id($post->slug, $post->id)) . '#comment-' . $record->id,
                                PostType::Page => route('pages.show', slug_id($post->slug, $post->id)) . '#comment-' . $record->id,
                                PostType::Tweet => route('tweets.show', slug_id($post->slug, $post->id)) . '#comment-' . $record->id,
                            };
                        },
                        true
                    ),
            ])
            ->toolbarActions([

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
                                        ->label('用户名')
                                        ->visible(fn(Comment $record) => $record->author != null),
                                    TextEntry::make('author.email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author != null),
                                    TextEntry::make('guest_name')
                                        ->label('用户名')
                                        ->visible(fn(Comment $record) => $record->author == null),
                                    TextEntry::make('guest_email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author == null),
                                    TextEntry::make('ip')
                                        ->label('IP')
                                ]),
                            Group::make()->schema([
                                TextEntry::make('status')
                                    ->label('状态')
                                    ->badge()
                                    ->color(fn(CommentStatus $state) => match ($state) {
                                        CommentStatus::Approved => 'info',
                                        CommentStatus::Pending => 'warning',
                                        CommentStatus::Spam => 'danger',

                                    }),
                                TextEntry::make('created_at')
                                    ->label('发表时间')
                                    ->badge()
                                    ->dateTime()
                                    ->color('info'),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', '=', CommentStatus::Approved)
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
            'index' => ListComments::route('/'),
            //'create' => Pages\CreateComment::route('/create'),
            'edit' => EditComment::route('/{record}/edit'),
            'view' => ViewComment::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $modelClass = static::$model;

        return (string)$modelClass::where('status', '=', CommentStatus::Approved)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}
