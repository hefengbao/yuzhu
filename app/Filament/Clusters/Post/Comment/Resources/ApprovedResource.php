<?php

namespace App\Filament\Clusters\Post\Comment\Resources;

use App\Constant\Post\CommentStatus;
use App\Constant\Post\PostType;
use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages\EditComment;
use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages\ListComments;
use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages\ViewComment;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApprovedResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $modelLabel = '已发布';
    protected static ?string $pluralModelLabel = '已发布';
    protected static ?string $cluster = \App\Filament\Clusters\Post\Comment::class;
    protected static ?string $slug = 'approved';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
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
                Tables\Columns\TextColumn::make('user_name')
                    ->label('作者')
                    ->description(fn(Comment $record) => $record->user_email),
                Tables\Columns\TextColumn::make('ip')->label('IP'),
                Tables\Columns\TextColumn::make('body')
                    ->label('内容')
                    ->wrap()
                    ->description(fn(?Comment $record): string => $record?->parent != null ? '引用：' . $record->parent->body : ''),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')->badge()
                    ->description(fn(Comment $record) => $record->created_at->format('Y-m-d H:i:s')),
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
            ->bulkActions([

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
                                        ->label('用户名')
                                        ->visible(fn(Comment $record) => $record->author != null),
                                    Infolists\Components\TextEntry::make('author.email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author != null),
                                    Infolists\Components\TextEntry::make('guest_name')
                                        ->label('用户名')
                                        ->visible(fn(Comment $record) => $record->author == null),
                                    Infolists\Components\TextEntry::make('guest_email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author == null),
                                    Infolists\Components\TextEntry::make('ip')
                                        ->label('IP')
                                ]),
                            Infolists\Components\Group::make()->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->label('状态')
                                    ->badge()
                                    ->color(fn(CommentStatus $state) => match ($state) {
                                        CommentStatus::Approved => 'info',
                                        CommentStatus::Pending => 'warning',
                                        CommentStatus::Spam => 'danger',

                                    }),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('发表时间')
                                    ->badge()
                                    ->dateTime()
                                    ->color('info'),
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
