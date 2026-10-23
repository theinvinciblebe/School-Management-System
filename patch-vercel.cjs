const fs = require('fs');
const path = require('path');

console.log('[patch-vercel] Starting vercel-php patch process...');

function patchVercelPhpDir(dir) {
  let patchedAny = false;
  
  // 1. Patch dist/index.js
  const indexPath = path.join(dir, 'dist', 'index.js');
  if (fs.existsSync(indexPath)) {
    try {
      let content = fs.readFileSync(indexPath, 'utf8');
      let changed = false;
      if (content.includes("handler: 'launcher.launcher'")) {
        content = content.replace(/handler:\s*['"]launcher\.launcher['"]/g, "handler: 'launcher.js'");
        changed = true;
      }
      if (changed) {
        fs.writeFileSync(indexPath, content, 'utf8');
        console.log(`[patch-vercel] Successfully patched: ${indexPath}`);
        patchedAny = true;
      }
    } catch (e) {
      console.warn(`[patch-vercel] Error patching ${indexPath}:`, e.message);
    }
  }

  // 2. Patch dist/utils.js to add launcher.launcher alias in getLauncherFiles()
  const utilsPath = path.join(dir, 'dist', 'utils.js');
  if (fs.existsSync(utilsPath)) {
    try {
      let content = fs.readFileSync(utilsPath, 'utf8');
      // Clean up previous faulty replacement if present
      content = content.replace("files['launcher.launcher'] = files['launcher.js'];\n    files['launcher.js'] =", "files['launcher.js'] =");
      if (content.includes("return files;") && !content.includes("files['launcher.launcher'] = files['launcher.js'];")) {
        content = content.replace(
          "return files;",
          "files['launcher.launcher'] = files['launcher.js'];\n    return files;"
        );
        fs.writeFileSync(utilsPath, content, 'utf8');
        console.log(`[patch-vercel] Successfully patched: ${utilsPath}`);
        patchedAny = true;
      }
    } catch (e) {
      console.warn(`[patch-vercel] Error patching ${utilsPath}:`, e.message);
    }
  }

  // 3. Patch dist/launchers/builtin.js
  const builtinPath = path.join(dir, 'dist', 'launchers', 'builtin.js');
  if (fs.existsSync(builtinPath)) {
    try {
      let content = fs.readFileSync(builtinPath, 'utf8');
      let changed = false;
      
      // Ensure LAMBDA_TASK_ROOT fallback
      if (!content.includes("process.env.LAMBDA_TASK_ROOT =")) {
        content = 'process.env.LAMBDA_TASK_ROOT = process.env.LAMBDA_TASK_ROOT || "/var/task";\n' + content;
        changed = true;
      }
      
      // Ensure exports for Node ESM compatibility
      if (!content.includes("module.exports.default = launcher;")) {
        content += '\nmodule.exports = launcher;\nmodule.exports.launcher = launcher;\nmodule.exports.default = launcher;\n';
        changed = true;
      }

      if (changed) {
        fs.writeFileSync(builtinPath, content, 'utf8');
        console.log(`[patch-vercel] Successfully patched: ${builtinPath}`);
        patchedAny = true;
      }
    } catch (e) {
      console.warn(`[patch-vercel] Error patching ${builtinPath}:`, e.message);
    }
  }

  // 4. Patch dist/launchers/helpers.js
  const helpersPath = path.join(dir, 'dist', 'launchers', 'helpers.js');
  if (fs.existsSync(helpersPath)) {
    try {
      let content = fs.readFileSync(helpersPath, 'utf8');
      let changed = false;

      // Fix getUserDir and getPhpDir fallback to /var/task instead of /
      if (content.includes("process.env.LAMBDA_TASK_ROOT || '/'")) {
        content = content.replace(/process\.env\.LAMBDA_TASK_ROOT\s*\|\|\s*'(\/)'/g, "process.env.LAMBDA_TASK_ROOT || '/var/task'");
        changed = true;
      }

      // Fix array body parsing in normalizeEvent
      if (content.includes("let { body } = invokeEvent;") && !content.includes("Array.isArray(body)")) {
        content = content.replace(
          "let { body } = invokeEvent;",
          "let { body } = invokeEvent;\n        if (Array.isArray(body)) body = Buffer.from(body);"
        );
        changed = true;
      }
      if (content.includes("const { httpMethod: method, path, host, headers = {}, body, } = event;") && !content.includes("const normalizedBody = Array.isArray(body)")) {
        content = content.replace(
          "const { httpMethod: method, path, host, headers = {}, body, } = event;",
          "const { httpMethod: method, path, host, headers = {}, body: rawBody, } = event;\n    const body = Array.isArray(rawBody) ? Buffer.from(rawBody) : rawBody;"
        );
        changed = true;
      }

      if (changed) {
        fs.writeFileSync(helpersPath, content, 'utf8');
        console.log(`[patch-vercel] Successfully patched: ${helpersPath}`);
        patchedAny = true;
      }
    } catch (e) {
      console.warn(`[patch-vercel] Error patching ${helpersPath}:`, e.message);
    }
  }

  return patchedAny;
}

function searchAndPatch(startDir, maxDepth = 6, currentDepth = 0) {
  if (currentDepth > maxDepth || !fs.existsSync(startDir)) return;

  try {
    // If startDir is itself a vercel-php directory
    if (path.basename(startDir) === 'vercel-php' || path.basename(startDir).startsWith('vercel-php@')) {
      patchVercelPhpDir(startDir);
      return;
    }

    const entries = fs.readdirSync(startDir, { withFileTypes: true });
    for (const entry of entries) {
      const fullPath = path.join(startDir, entry.name);
      if (entry.isDirectory()) {
        if (['proc', 'sys', 'dev', '.git'].includes(entry.name) || entry.name.startsWith('squashfs')) continue;
        if (entry.name === 'vercel-php' || (entry.name.startsWith('vercel-php@'))) {
          patchVercelPhpDir(fullPath);
        } else {
          searchAndPatch(fullPath, maxDepth, currentDepth + 1);
        }
      }
    }
  } catch (err) {}
}

const candidateRoots = [
  '/vercel/path0/.vercel/builders/node_modules/vercel-php',
  '/vercel/path0/node_modules/vercel-php',
  path.resolve(__dirname, 'node_modules/vercel-php'),
  '/vercel',
  '/root/.vercel',
  path.resolve(__dirname),
].filter(p => p && fs.existsSync(p));

console.log('[patch-vercel] Searching in roots:', candidateRoots);
for (const root of candidateRoots) {
  searchAndPatch(root);
}

console.log('[patch-vercel] Completed patch process.');
