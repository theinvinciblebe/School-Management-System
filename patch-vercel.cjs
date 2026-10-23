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

      // Track PHP stderr to diagnose port opening / startup failures
      if (!content.includes("let lastPhpStderr = '';")) {
        content = "let lastPhpStderr = '';\n" + content;
        changed = true;
      }
      if (content.includes("console.error(`🐘STDERR: ${data.toString()}`);") && !content.includes("lastPhpStderr +=")) {
        content = content.replace(
          "console.error(`🐘STDERR: ${data.toString()}`);",
          "console.error(`🐘STDERR: ${data.toString()}`);\n        lastPhpStderr += data.toString();"
        );
        changed = true;
      }

      // Increase timeout for cold starts (10 seconds instead of 5)
      if (content.includes("whenPortOpens(3000, 500)")) {
        content = content.replace("whenPortOpens(3000, 500)", "whenPortOpens(3000, 1000)");
        changed = true;
      }

      // Wrap launcher in try/catch to eliminate unhandled rejection (FUNCTION_INVOCATION_FAILED)
      if (content.includes("async function launcher(event) {") && !content.includes("/* CATCH_INVOCATION_FAIL */")) {
        content = content.replace(
          "async function launcher(event) {",
          "async function launcher(event) {\n    /* CATCH_INVOCATION_FAIL */\n    try {"
        );
        content = content.replace(
          "return (0, helpers_1.transformToAwsResponse)(output);\n}",
          `return (0, helpers_1.transformToAwsResponse)(output);\n    } catch (err) {\n        console.error('🐘 Fatal launcher error:', err);\n        const msg = (err && err.message) ? err.message : String(err);\n        const stack = (err && err.stack) ? err.stack : '';\n        const bodyHtml = \`<html><body style="font-family:sans-serif;padding:30px;line-height:1.6;background:#fef2f2;color:#991b1b;"><h2>Serverless Function Execution Error</h2><p><strong>Error:</strong> \${msg}</p>\${lastPhpStderr ? \`<p><strong>PHP Stderr:</strong></p><pre style="background:#fff;padding:15px;border-radius:6px;border:1px solid #fca5a5;">\${lastPhpStderr}</pre>\` : ''}<pre style="background:#fff;padding:15px;border-radius:6px;overflow:auto;">\${stack}</pre></body></html>\`;\n        return {\n            statusCode: 500,\n            headers: { 'content-type': 'text/html; charset=utf-8' },\n            body: Buffer.from(bodyHtml).toString('base64'),\n            isBase64Encoded: true\n        };\n    }\n}`
        );
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

if (process.platform === 'linux') {
  try {
    const { execSync } = require('child_process');
    const stdout = execSync('find /vercel /tmp /root -name "index.js" -path "*vercel-php*" 2>/dev/null', { encoding: 'utf8' });
    const files = stdout.split('\n').map(s => s.trim()).filter(Boolean);
    for (const file of files) {
      if (!file.includes('squashfs')) {
        console.log(`[patch-vercel] Linux find located: ${file}`);
        const dir = path.dirname(path.dirname(file)); // up from dist/index.js
        patchVercelPhpDir(dir);
      }
    }
  } catch (e) {
    console.warn('[patch-vercel] find command warning:', e.message);
  }
}

const candidateRoots = [
  '/vercel/path0/.vercel/builders/node_modules/vercel-php',
  '/vercel/path0/node_modules/vercel-php',
  path.resolve(__dirname, 'node_modules/vercel-php'),
  '/vercel',
  '/tmp',
  '/root/.vercel',
  path.resolve(__dirname),
].filter(p => p && fs.existsSync(p));

console.log('[patch-vercel] Searching in roots:', candidateRoots);
for (const root of candidateRoots) {
  searchAndPatch(root);
}

console.log('[patch-vercel] Completed patch process.');
