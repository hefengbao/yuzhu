<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\SiteResource\Pages\CreateSite;
use App\Models\Option;
use App\Services\OptionService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SiteResource extends Resource
{
    protected static ?string $model = Option::class;

    protected static ?string $modelLabel = '设置';

    protected static ?string $navigationLabel = '站点';

    protected static string|\UnitEnum|null $navigationGroup = '设置';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public static function form(Schema $schema): Schema
    {
        $optionServe = new OptionService();

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('站点标题')
                    ->hint('起个有趣的名字吧')
                    ->default($optionServe->options()['title'] ?? '')
                    ->columnSpanFull(),
                TextInput::make('subtitle')
                    ->label('站点副标题')
                    ->hint('用简洁的文字描述本站点')
                    ->default($optionServe->options()['subtitle'] ?? '')
                    ->columnSpanFull(),
                Textarea::make('keywords')
                    ->label('站点关键词')
                    ->hint('定义个性化的关键词,请用英文逗号（,）分割')
                    ->default($optionServe->options()['keywords'] ?? '')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('站点描述')
                    ->hint('对站点的详细描述，200 字内')
                    ->default($optionServe->options()['description'] ?? '')
                    ->columnSpanFull()
                    ->maxLength(200),
                TextInput::make('icp')
                    ->label('ICP 备案号')
                    ->default($optionServe->options()['icp'] ?? '')
                    ->columnSpanFull(),
                TextInput::make('gwb')
                    ->label('公安联网备案信息')
                    ->hint('ICP 备案后，在 https://beian.mps.gov.cn 完成网站联网备案,备案成功后复制相应的 HTML 代码')
                    ->default($optionServe->options()['gwb'] ?? '')
                    ->columnSpanFull(),
                TextInput::make('other_footer_links')
                    ->label('其他底部链接')
                    ->hint('填写对应的 HTML 代码')
                    ->default($optionServe->options()['other_footer_links'] ?? '')
                    ->columnSpanFull(),
                Textarea::make('site_verify_meta')
                    ->label('搜索引擎验证 Meta')
                    ->hint('在常用的搜索引擎验证提交验证网站')
                    ->default($optionServe->options()['site_verify_meta'] ?? '')
                    ->columnSpanFull(),
                Textarea::make('site_analytics')
                    ->label('网站分析平台接入代码')
                    ->default($optionServe->options()['site_analytics'] ?? '')
                    ->columnSpanFull(),
                Select::make('users_can_register')
                    ->label('注册功能')
                    ->hint('如果开启，则意味着其他用户可注册并在本站点发布文章等。')
                    ->default($optionServe->options()['users_can_register'] ?? '')
                    ->columnSpanFull()
                    ->options([
                        0 => '关闭',
                        1 => '开启',
                    ]),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => CreateSite::route('/'),
        ];
    }
}
