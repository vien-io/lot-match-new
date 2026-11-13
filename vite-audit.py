
import re
import json
from pathlib import Path

manifest_path = Path("public/build/manifest.json")

if not manifest_path.exists():
    print("ERROR: Manifest not found. Run npm run build first.")
    raise SystemExit(1)

manifest = json.loads(manifest_path.read_text())

references = []

# Scan all Blade templates
for blade in Path("resources/views").rglob("*.blade.php"):
    content = blade.read_text(errors="replace")

    # Find all @vite(...) directives
    for match in re.finditer(r"@vite\s*\((.*?)\)", content, re.DOTALL):
        paths = re.findall(
            r"""['"]((?:resources/)[^'"]+\.(?:js|css))['"]""",
            match.group(1)
        )

        for path in paths:
            references.append((path, blade))

print("\n========== VITE MANIFEST AUDIT ==========\n")

missing = []
valid = []

for path, blade in references:
    if path not in manifest:
        missing.append((path, blade))
        print(f"[MISSING] {path}")
        print(f"          Referenced in: {blade}")
    else:
        valid.append(path)
        print(f"[OK]      {path}")

print("\n========== SUMMARY ==========\n")
print(f"Total references: {len(references)}")
print(f"Valid:            {len(valid)}")
print(f"Missing:          {len(missing)}")

if missing:
    print("\nFix all MISSING references before deploying.")
else:
    print("\nAll detected Blade Vite references exist in the manifest!")
