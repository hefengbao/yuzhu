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
            { text: '什么是『玉竹』？', link: '/guide/what-is-yuzhu' },
            { text: '搭建环境', link: '/guide/getting-started' },
            { text: '部署', link: '/guide/deploy' },
            { text: 'App', link: '/guide/app' },
            { text: 'FAQ', link: '/guide/faq' },
          ]
        }
      ]
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/hefengbao/yuzhu' }
    ]
  }
})
