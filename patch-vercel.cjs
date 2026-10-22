const fs = require('fs');
const path = require('path');

function patchFile(filePath) {
  try {
    let content = fs.readFileSync(filePath, 'utf8');
    if (content.includes("handler: 'launcher.launcher'")) {
      content = content.replace(/handler:\s*['"]launcher\.launcher['"]/g, "handler: 'launcher.js'");
      fs.writeFileSync(filePath, content, 'utf8');
      console.log(`[PATCHED] Successfully patched vercel-php handler in: ${filePath}`);
      return true;
    }
  } catch (err) {}
  return false;
}

function walkDir(dir) {
  try {
    const list = fs.readdirSync(dir, { withFileTypes: true });
    for (const item of list) {
      const full = path.join(dir, item.name);
      if (item.isDirectory()) {
        if (!['proc', 'sys', 'dev'].includes(item.name)) {
          walkDir(full);
        }
      } else if (item.name === 'index.js' && full.includes('vercel-php')) {
        patchFile(full);
      }
    }
  } catch (err) {}
}

console.log('Running patch-vercel.cjs to fix vercel-php handler...');
// Check common Vercel builder locations
const candidatePaths = [
  '/vercel',
  '/root/.vercel',
  path.resolve(__dirname, 'node_modules'),
  path.resolve(__dirname, '../node_modules'),
];

for (const p of candidatePaths) {
  if (fs.existsSync(p)) {
    walkDir(p);
  }
}
console.log('Finished patch-vercel.cjs.');
