#!/bin/bash
set +e

echo "[build-patch] Searching for vercel-php runtime files..."
FILES=$(find /vercel /tmp -name "index.js" -path "*vercel-php*" 2>/dev/null)

for f in $FILES; do
  if [ -w "$f" ]; then
    echo "[build-patch] Patching writable index: $f"
    sed -i "s/handler: 'launcher.launcher'/handler: 'launcher.js'/g" "$f"
    sed -i 's/handler: "launcher.launcher"/handler: "launcher.js"/g' "$f"

    # Also patch corresponding utils.js in the same directory
    UTILS_FILE="$(dirname "$f")/utils.js"
    if [ -w "$UTILS_FILE" ]; then
      echo "[build-patch] Patching writable utils: $UTILS_FILE"
      sed -i "s/return files;/files['launcher.launcher'] = files['launcher.js'];\n    return files;/g" "$UTILS_FILE"
    fi
  fi
done

echo "[build-patch] Completed."
