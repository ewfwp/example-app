import { readFile, writeFile } from 'node:fs/promises';
import { PurgeCSS } from 'purgecss';
import postcss from 'postcss';
import prefixSelector from 'postcss-prefix-selector';
import { readFileSync } from 'node:fs';

// Get name from the package.json file
const { name } = JSON.parse(readFileSync(new URL('./package.json', import.meta.url), 'utf8'));

const bootstrapFile = 'node_modules/bootstrap/dist/css/bootstrap.min.css';
const angularStylesFile = `dist/${name}/browser/styles.css`;
const targetFile = `${name}/web-component/assets/styles.css`;

const [purged] = await new PurgeCSS().purge({
  content: ['src/**/*.html', 'src/**/*.ts'],
  css: [bootstrapFile],
});

const prefixed = await postcss([prefixSelector({ prefix: name })]).process(purged.css, {
  from: bootstrapFile,
  to: targetFile,
  map: false,
});

const angularStyles = await readFile(angularStylesFile, 'utf8');
await writeFile(targetFile, `${angularStyles}\n${prefixed.css}`);

console.info('Styles geschreven met opgeschoonde en geprefixte Bootstrap.');
