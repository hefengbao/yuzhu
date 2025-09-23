<?php

namespace App\Services\Finance;

use App\Constant\FMS\FinanceType;
use App\Models\FMS\Category;
use App\Models\FMS\Group;
use App\Models\User;

/**
 * 根据
 * [居民消费支出分类(2013) - 国家统计局](https://www.stats.gov.cn/xxgk/tjbz/gjtjbz/201310/P020200612582958212339.PDF)
 * [https://www.stats.gov.cn/sj/ndsj/2015/html/zb06.htm](https://www.stats.gov.cn/sj/ndsj/2015/html/zb06.htm)
 */
class SeedCategories
{
    public function seed(User $user)
    {
        $data = [
            [
                'group' => [
                    'name' => '食品烟酒',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '食品',
                        'items' => [
                            '谷物',
                            '薯类',
                            '豆类',
                            '食用油和食用油脂',
                            '蔬菜及食用菌',
                            '畜肉类',
                            '禽肉类',
                            '水产品',
                            '蛋类',
                            '奶类',
                            '干鲜瓜果类',
                            '糖果糕点类',
                            '其他食品',
                            '其他食品',
                        ]
                    ],
                    [
                        'name' => '饮料（不含酒精）',
                        'items' => []
                    ],
                    [
                        'name' => '烟酒',
                        'items' => [
                            '烟草',
                            '酒类',
                        ]
                    ],
                    [
                        'name' => '饮食服务',
                        'items' => []
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => '衣着',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '衣类',
                        'items' => [
                            '服装',
                            '服装材料',
                            '其他衣类及配件',
                            '衣类加工服务费',
                        ]
                    ],
                    [
                        'name' => '鞋类',
                        'items' => [
                            '鞋',
                            '鞋类配件及加工服务费',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '居住',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '租赁房房租',
                        'items' => [
                            '租赁公房房租',
                            '租赁私房房租',
                        ]
                    ],
                    [
                        'name' => '住房保养、维修及管理',
                        'items' => [
                            '住房装潢和维修',
                            '物业管理费',
                            '住房其他保养、维修及管理',
                        ]
                    ],
                    [
                        'name' => '水、电、燃料及其他',
                        'items' => [
                            '水',
                            '电',
                            '燃料',
                            '取暖费',
                            '其他水、电、燃料等',
                        ]
                    ],
                    [
                        'name' => '自有住房折算租金',
                        'items' => []
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '生活用品及服务',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '家具及室内装饰品',
                        'items' => [
                            '家具',
                            '家具材料',
                            '室内装饰品',
                        ]
                    ],
                    [
                        'name' => '家用器具',
                        'items' => [
                            '大型家用器具',
                            '小型家用电器',
                            '家用电动工具和设备',
                        ]
                    ],
                    [
                        'name' => '家用纺织品',
                        'items' => [
                            '床上用品',
                            '窗帘门帘',
                            '其他家用纺织品',
                        ]
                    ],
                    [
                        'name' => '家庭日用杂品',
                        'items' => [
                            '洗涤及卫生用品',
                            '厨具、餐具、茶具等',
                            '家用手工工具',
                            '其他家庭日用杂品',
                        ]
                    ],
                    [
                        'name' => '个人护理用品',
                        'items' => [
                            '化妆品',
                            '其他个人护理用品',
                        ]
                    ],
                    [
                        'name' => '家庭服务',
                        'items' => [
                            '家政服务',
                            '家庭设备修理',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '交通和通信',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '交通',
                        'items' => [
                            '交通工具',
                            '交通工具用燃料等',
                            '交通工具使用和维修',
                            '交通费',
                        ]
                    ],
                    [
                        'name' => '通信',
                        'items' => [
                            '通信工具',
                            '电信服务',
                            '邮递服务',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '教育、文化和娱乐',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '教育',
                        'items' => [
                            '学前教育',
                            '小学教育',
                            '高中教育',
                            '中专职高教育',
                            '高等教育',
                            '其他教育和培训',
                        ]
                    ],
                    [
                        'name' => '文化和娱乐',
                        'items' => [
                            '文化和娱乐耐用消费品',
                            '其他文化和娱乐用品',
                            '文化和娱乐服务',
                            '一揽子旅游度假服务',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '医疗保健',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '医疗器具及药品',
                        'items' => [
                            '药品',
                            '滋补保健品',
                            '医疗卫生器具',
                            '保健器具',
                        ]
                    ],
                    [
                        'name' => '医疗服务',
                        'items' => [
                            '门诊医疗费',
                            '住院医疗费',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '其他用品和服务',
                    'type' => FinanceType::Expense,
                ],
                'categories' => [
                    [
                        'name' => '其他用品',
                        'items' => [
                            '首饰、手表',
                            '未列明的其他用品',
                        ]
                    ],
                    [
                        'name' => '其他服务',
                        'items' => [
                            '旅馆住宿',
                            '美容、美发和洗浴',
                            '社会保护',
                            '保险',
                            '金融',
                            '未列明的其他服务',
                        ]
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '工资性收入',
                    'type' => FinanceType::Income,
                ],
                'categories' => [
                    [
                        'name' => '工资',
                        'items' => []
                    ],
                    [
                        'name' => '奖金',
                        'items' => []
                    ],
                    [
                        'name' => '津贴和补贴',
                        'items' => []
                    ],
                    [
                        'name' => '加班加点工资',
                        'items' => []
                    ],
                    [
                        'name' => '福利',
                        'items' => []
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '经营性收入',
                    'type' => FinanceType::Income,
                ],
                'categories' => [
                    [
                        'name' => '销售货物',
                        'items' => []
                    ],
                    [
                        'name' => '提供劳务',
                        'items' => []
                    ],
                    [
                        'name' => '让渡资产使用权',
                        'items' => []
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '财产性收入',
                    'type' => FinanceType::Income,
                ],
                'categories' => [
                    [
                        'name' => '利息净收入',
                        'items' => []
                    ],
                    [
                        'name' => '红利收入',
                        'items' => []
                    ],
                    [
                        'name' => '储蓄性保险净收益',
                        'items' => []
                    ],
                    [
                        'name' => '转让承包土地经营权租金净收入',
                        'items' => []
                    ],
                    [
                        'name' => '出租房屋净收入',
                        'items' => []
                    ],
                    [
                        'name' => '出租其他资产净收入',
                        'items' => []
                    ],
                    [
                        'name' => '自有住房折算净租金',
                        'items' => []
                    ],
                ]
            ],
            [
                'group' => [
                    'name' => '转移性收入',
                    'type' => FinanceType::Income,
                ],
                'categories' => [
                    [
                        'name' => '养老金或退休金',
                        'items' => []
                    ],
                    [
                        'name' => '社会救济和补助',
                        'items' => []
                    ],
                    [
                        'name' => '政策性生产补贴',
                        'items' => []
                    ],
                    [
                        'name' => '政策性生活补贴',
                        'items' => []
                    ],
                    [
                        'name' => '救灾款',
                        'items' => []
                    ],
                    [
                        'name' => '经常性捐赠和赔偿',
                        'items' => []
                    ],
                    [
                        'name' => '报销医疗费',
                        'items' => []
                    ],
                    [
                        'name' => '赡养收入',
                        'items' => []
                    ],
                    [
                        'name' => '本住户非常住成员寄回带回的收入',
                        'items' => []
                    ],
                ]
            ],
        ];

        foreach ($data as $item) {
            $item['group']['user_id'] = $user->id;
            $group = Group::create($item['group']);

            foreach ($item['categories'] as $category) {
                $category['user_id'] = $user->id;
                $category['group_id'] = $group->id;
                Category::create($category);
            }
        }
    }
}
