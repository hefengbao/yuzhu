<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\SiteResource\Pages;
use App\Filament\Resources\Settings\SiteResource\RelationManagers;
use App\Models\Option;
use App\Services\OptionService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteResource extends Resource
{
    protected static ?string $model = Option::class;
    protected static ?string $modelLabel = '设置';
    protected static ?string $navigationLabel = '站点';
    protected static ?string $navigationGroup = '设置';

    public static function form(Form $form): Form
    {
        $optionServe = new OptionService();

        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('站点标题')
                    ->hint('起个有趣的名字吧')
                    ->default($optionServe->options()['title'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('subtitle')
                    ->label('站点副标题')
                    ->hint('用简洁的文字描述本站点')
                    ->default($optionServe->options()['subtitle'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('keywords')
                    ->label('站点关键词')
                    ->hint('定义个性化的关键词,请用英文逗号（,）分割')
                    ->default($optionServe->options()['keywords'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('站点描述')
                    ->hint('对站点的详细描述，200 字内')
                    ->default($optionServe->options()['description'] ?? '')
                    ->columnSpanFull()
                    ->maxLength(200),
                Forms\Components\TextInput::make('icp')
                    ->label('ICP 备案号')
                    ->default($optionServe->options()['icp'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('site_verify_meta')
                    ->label('搜索引擎验证 Meta')
                    ->hint('在常用的搜索引擎验证提交验证网站')
                    ->default($optionServe->options()['site_verify_meta'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('site_analytics')
                    ->label('网站分析平台接入代码')
                    ->default($optionServe->options()['site_analytics'] ?? '')
                    ->columnSpanFull(),
                Forms\Components\Select::make('users_can_register')
                    ->label('注册功能')
                    ->hint('如果开启，则意味着其他用户可注册并在本站点发布文章等。')
                    ->default($optionServe->options()['users_can_register'] ?? '')
                    ->columnSpanFull()
                    ->options([
                        0 => '关闭',
                        1 => '开启',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\CreateSite::route('/'),
        ];
    }
}
