import { readFileSync } from 'node:fs';
import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import postcssPrefixSelector from 'postcss-prefix-selector';

// Get name from the package.json file
const { name } = JSON.parse(readFileSync(new URL('./package.json', import.meta.url), 'utf8'));

export default defineConfig({
  build: {
    outDir: `${name}/web-component`,
    emptyOutDir: true,
    sourcemap: true,

    rolldownOptions: {
      input: 'vite.build.collector.js',

      output: {
        entryFileNames: 'web-component.js',
        format: 'iife',
        inlineDynamicImports: true,
      },
    },
  },
  css: {
    postcss: {
      plugins: [
        postcssPrefixSelector({
          prefix: name,
        }),
      ],
    },
  },
  plugins: [
    viteStaticCopy({
      targets: [
        {
          src: `dist/${name}/browser/styles.css`,
          dest: 'assets',
          rename: { stripBase: true },
        },
      ],
    }),
  ],
});
