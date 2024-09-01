import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  lang: 'zh-Hans',
  title: "One",
  description: "简洁的博客、微博客系统",
  base: "/yuzhu/",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: '首页', link: '/' },
      { text: '指南', link: '/guide/what-is-one', activeMatch: '/guide/*' },
    ],

    sidebar: {
      '/guide/': [
        {
          text: '简介',
          items: [
            { text: '什么是 One？', link: '/guide/what-is-one' },
            { text: '快速开始', link: '/guide/getting-started' },
            { text: '部署', link: '/guide/deploy' },
          ]
        }
      ]
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/hefengbao/yuzhu' }
    ]
  }
})
