#!/bin/bash
set +e

echo "[build-patch] Searching for vercel-php runtime files..."
FILES=$(find /vercel /tmp -name "index.js" -path "*vercel-php*" 2>/dev/null)

for f in $FILES; do
  if [ -w "$f" ]; then
    echo "[build-patch] Patching writable file: $f"
    sed -i "s/handler: 'launcher.launcher'/handler: 'launcher.js'/g" "$f"
    sed -i 's/handler: "launcher.launcher"/handler: "launcher.js"/g' "$f"
  fi
done

echo "[build-patch] Completed."
