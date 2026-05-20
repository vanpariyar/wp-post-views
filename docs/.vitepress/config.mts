import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  base: '/wp-post-views/',
  cleanUrls: true,
  title: "WP Post Views",
  description: "Lightweight Post Views Counter for WordPress",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/getting-started' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'Getting Started', link: '/guide/getting-started' },
          { text: 'Configuration', link: '/guide/configuration' },
        ]
      },
      {
        text: 'Developers',
        items: [
          { text: 'Shortcodes', link: '/guide/shortcodes' },
          { text: 'PHP Functions', link: '/guide/functions' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/vanpariyar/wp-post-views' }
    ],

    footer: {
      message: 'Released under the GPL-2.0 License.',
      copyright: 'Copyright © 2024-present Ronak J Vanpariya'
    }
  }
})
