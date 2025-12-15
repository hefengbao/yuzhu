<?php

namespace App\Filament\Clusters\FMS\CategoryTag;

use Filament\Clusters\Cluster;
use UnitEnum;

class CategoryTagCluster extends Cluster
{
    protected static ?string $navigationLabel = '分类/标签';
    protected static string|UnitEnum|null $navigationGroup = '财务';
    protected static ?int $navigationSort = 4;
    protected static ?string $clusterBreadcrumb = '分类/标签';
    protected static ?string $slug = 'fms/category-tag';
}
