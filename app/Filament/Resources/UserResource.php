<?php

namespace App\Filament\Resources;

use App\Constant\Role;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = '用户';

    protected static ?string $pluralModelLabel = '用户';

    protected static ?string $navigationLabel = '用户';

    protected static string|\UnitEnum|null $navigationGroup = '用户';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('用户名')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('邮箱')
                    ->email()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->label('密码')
                    ->hint('密码至少 8 位')
                    ->password()
                    ->minLength(8)
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->columnSpanFull(),
                Select::make('role')
                    ->label('角色')
                    ->hint('请谨慎授予管理员、编辑角色。')
                    ->options(Role::class)
                    ->default(Role::Author)
                    ->required()
                    ->visible(auth()->user()->isAdministrator())
                    ->columnSpanFull(),
                Textarea::make('bio')
                    ->label('个人简介')
                    ->columnSpanFull(),
                FileUpload::make('avatar')
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
                ImageColumn::make('avatar')
                    ->label('头像')
                    ->circular()
                    ->grow(false),
                TextColumn::make('name')
                    ->label('用户名'),
                TextColumn::make('email')
                    ->label('邮箱')
                    ->suffix(fn(User $record): string => $record->email_verified_at !== null ? '✅' : ''),
                TextColumn::make('role')
                    ->label('角色')
                    ->badge()
                    ->color(fn(Role $state): string => match ($state) {
                        Role::Administrator => 'primary',
                        Role::Editor => 'info',
                        Role::Author => 'gray',
                    }),
                TextColumn::make('deleted_at')
                    ->label('状态')
                    ->badge()
                    ->default('')
                    ->formatStateUsing(fn($state): string => $state !== '' ? '禁用' : '有效')
                    ->color(fn($state): string => $state !== '' ? 'danger' : 'success'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn(User $record): bool => $auth->isAdministrator() || $record->id === $auth->id),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
