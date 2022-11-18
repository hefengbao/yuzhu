module.exports = {
    base: '/one/',
    title: 'One',
    description: 'One 文档',
    themeConfig: {
        nav: [
            { text: '首页', link: '/' },
            { text: '文档', link: '/doc/' },
            { text: 'Github', link: 'https://github.com/hefengbao/one' },
        ]
    },
    plugins: [
        '@vuepress/search', {
            searchMaxSuggestions: 10
        },
        '@vuepress/active-header-links',{
            sidebarLinkSelector: '.sidebar-link',
            headerAnchorSelector: '.header-anchor'
        },
        '@vuepress/back-to-top',
        '@vuepress/last-updated'
    ]
}
