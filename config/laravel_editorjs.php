<?php

return [
    'config'    => [
        'tools' => [
            'paragraph' => [
                'text'  => [
                    'type'          => 'string',
                    'allowedTags'   => 'i,b,a[href],code[class],mark[class]',
                ],
            ],
            'header' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'a[href],mark[class]',
                ],
                'level' => [1, 2, 3, 4, 5, 6],
            ],
            'list' => [
                'style' => [
                    0 => 'ordered',
                    1 => 'unordered',
                ],
                'items' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'string',
                            'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                        ],
                    ],
                ],
            ],
            'linkTool' => [
                'link' => 'string',
                'meta' => [
                    'type' => 'array',
                    'data' => [
                        'title' => [
                            'type' => 'string',
                        ],
                        'description' => [
                            'type' => 'string',
                        ],
                        'url' => [
                            'type' => 'string',
                            'required' => false,
                        ],
                        'domain' => [
                            'type' => 'string',
                            'required' => false,
                        ],
                        'image' => [
                            'type' => 'array',
                            'required' => false,
                            'data' => [
                                'url' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'image' => [
                'file' => [
                    'type' => 'array',
                    'data' => [
                        'width' => [
                            'type' => 'integer',
                            'required' => false,
                        ],
                        'height' => [
                            'type' => 'integer',
                            'required' => false,
                        ],
                        'url' => 'string',
                    ],
                ],
                'caption' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'withBorder' => 'boolean',
                'withBackground' => 'boolean',
                'stretched' => 'boolean',
            ],
            'table' => [
                'withHeadings' => 'boolean',
                'content' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                '-' => [
                                    'type' => 'string',
                                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'quote' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'caption' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'alignment' => [
                    0 => 'left',
                    1 => 'center',
                ],
            ],
            'code' => [
                'code' => [
                    'type' => 'string',
                    'allowedTags' => '*',
                ],
            ],
            'delimiter' => [],
            'raw' => [
                'html' => [
                    'type' => 'string',
                    'allowedTags' => '*',
                ],
            ],
        ],
    ],
];