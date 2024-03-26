<?php

namespace App\Filament\Resources;

use App\Constant\Role;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = '用户';

    protected static ?string $pluralModelLabel = '用户';

    protected static ?string $navigationLabel = '用户';

    protected static ?string $navigationGroup = '用户';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('用户名')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->label('邮箱')
                    ->email()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('password')
                    ->label('密码')
                    ->hint('密码至少 8 位')
                    ->password()
                    ->minLength(8)
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->columnSpanFull(),
                Forms\Components\Select::make('role')
                    ->label('角色')
                    ->hint('请谨慎授予管理员、编辑角色。')
                    ->options(Role::class)
                    ->default(Role::Author)
                    ->required()
                    ->visible(auth()->user()->isAdministrator())
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bio')
                    ->label('个人简介')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('avatar')
                    ->label('头像')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->imageCropAspectRatio('1:1')
                    ->directory('upload/avatars/' . date('Ymd'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var User $auth */
        $auth = auth()->user();

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('头像')
                    ->circular()
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->label('用户名'),
                Tables\Columns\TextColumn::make('email')
                    ->label('邮箱')
                    ->suffix(fn(User $record): string => $record->email_verified_at !== null ? '✅' : ''),
                Tables\Columns\TextColumn::make('role')
                    ->label('角色')
                    ->badge()
                    ->color(fn(Role $state): string => match ($state) {
                        Role::Administrator => 'primary',
                        Role::Editor => 'info',
                        Role::Author => 'gray',
                    }),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('状态')
                    ->badge()
                    ->default('')
                    ->formatStateUsing(fn($state): string => $state !== '' ? '禁用' : '有效')
                    ->color(fn($state): string => $state !== '' ? 'danger' : 'success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn(User $record): bool => $auth->isAdministrator() || $record->id === $auth->id),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User $auth */
        $auth = auth()->user();

        if ($auth->isAdministrator()) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        } else {
            return parent::getEloquentQuery()->where('id', $auth->id);
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
