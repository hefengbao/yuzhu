<?php

namespace App\Filament\Resources\Post;

use App\Constant\CommentStatus;
use App\Filament\Resources\Post\CommentResource\Pages;
use App\Filament\Resources\Post\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $modelLabel = "评论";
    protected static ?string $pluralModelLabel = "评论";
    //protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = "评论";
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = '写作';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('状态')
                    ->options(CommentStatus::class)
                    ->default(CommentStatus::Approved)
                    ->required()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->label('作者'),
                Tables\Columns\TextColumn::make('author.email')
                    ->label('邮箱'),
                Tables\Columns\TextColumn::make('body')
                    ->label('内容'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                /*Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),*/
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
                                        ->visible(fn(Comment $record) => $record->author() != null),
                                    Infolists\Components\TextEntry::make('author.email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author() != null),
                                    Infolists\Components\TextEntry::make('guest_name')
                                        ->label('用户名')
                                        ->visible(fn(Comment $record) => $record->author() == null),
                                    Infolists\Components\TextEntry::make('guest_email')
                                        ->label('邮箱')
                                        ->visible(fn(Comment $record) => $record->author() == null),
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
                                    ->color('info')
                            ])
                        ])
                ]),
            Infolists\Components\Section::make('内容')->schema([
                Infolists\Components\TextEntry::make('body')
                    ->hiddenLabel()
                    ->markdown()
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
            'view' => Pages\ViewComment::route('/{record}'),
        ];
    }
}
