<?php

namespace App\Filament\Pages\Settings;

use App\Models\Backup;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupsList extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = '备份';

    protected static string|\UnitEnum|null $navigationGroup = '设置';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.settings.backups-list';

    /**
     * 管理员显示菜单
     */
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * 判断从 url 跳转过来是否有访问权限
     */
    public function mount(): void
    {
        abort_unless(auth()->user()->isAdministrator(), 404);
    }

    public function table(Table $table): Table
    {
        $files = Storage::allFiles(config('app.name'));
        $files = collect($files)->sortDesc()->map(function ($item) {
            $strs1 = explode('/', $item);
            $strs2 = explode('-', $strs1[1]);

            return [
                'datetime' => Carbon::create(...$strs2)->format('Y-m-d H:i:s'),
                'name' => $strs1[1],
            ];
        });

        return $table
            ->records(fn(): array => $files->all())
            ->columns([
                TextColumn::make('name')->label('文件'),
                TextColumn::make('datetime')->label('时间'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('下载')
                    ->color('gray')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (array $record) {
                        return Storage::download(config('app.name') . '/' . $record['name']);
                    }),
                Action::make('del')
                    ->label('删除')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function (array $record) {
                        Storage::delete(config('app.name') . '/' . $record['name']);
                        return redirect('admin/backups-list');
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('立即运行备份')
                ->action(function () {
                    Artisan::call('backup:run');

                    return redirect('admin/backups-list');
                }),
        ];
    }
}
