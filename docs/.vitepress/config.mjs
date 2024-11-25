import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  lang: 'zh-Hans',
  title: "玉竹",
  description: "简洁的博客、微博客系统",
  base: "/yuzhu/",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: '首页', link: '/' },
      { text: '指南', link: '/guide/what-is-yuzhu', activeMatch: '/guide/*' },
    ],

    sidebar: {
      '/guide/': [
        {
          text: '',
          items: [
            {
              text: '介绍',
              items: [
                { text: '什么是『玉竹』？', link: '/guide/what-is-yuzhu' },
              ],
            },
            {
              text: '安装',
              items: [
                {
                  text: 'Linux',
                  items: [
                    { text: '搭建环境', link: '/guide/getting-started' },
                    { text: '部署', link: '/guide/deploy' },
                  ],
                },
                {
                  text: '宝塔 Linux 面板',
                  items: [
                    { text: '宝塔安装', link: '/guide/bt' },
                    { text: '搭建环境', link: '/guide/bt-env' },
                    { text: '部署', link: '/guide/bt-deploy' },
                  ],
                }
              ]
            },
            {
              text: '更新',
              items: [
                { text: '更新 & 升级', link: '/guide/update' },
              ],
            },
            {
              text: '其他',
              items: [
                { text: 'App', link: '/guide/app' },
                { text: 'FAQ', link: '/guide/faq' },
              ],
            },  
          ]
        }
      ]
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/hefengbao/yuzhu' }
    ]
  }
})
