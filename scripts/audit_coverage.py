import os
import re

v2_dir = "docs/Mission_Villa_Website_Content_Editorial_V2/pages"
guides_dir = "docs/content-update-guides"

pages = [
    "home", "living-options", "memory-care", "respite-care",
    "suites-and-floor-plans", "life-at-mission-villa", "services-and-amenities",
    "gallery", "about", "for-families", "financial-planning",
    "resources", "contact"
]

total_fields = 0
total_missing = 0

for p in pages:
    v2_path = os.path.join(v2_dir, f"{p}.md")
    g_path = os.path.join(guides_dir, f"{p}.md")
    
    with open(v2_path) as f:
        v2_src = f.read()
    with open(g_path) as f:
        g_src = f.read()
        
    v2_fields = re.findall(r"-\s+\*\*([^*]+):\*\*\s*(.+)", v2_src)
    total_fields += len(v2_fields)
    missing = []
    for label, val in v2_fields:
        clean_val = val.strip().strip("\"'").split("(")[0].strip()
        # skip file paths or short metadata labels
        if clean_val.startswith("`") and clean_val.endswith("`"):
            clean_val = clean_val.strip("`")
        if len(clean_val) > 12 and clean_val.lower() not in g_src.lower():
            missing.append((label, clean_val[:60]))
            
    total_missing += len(missing)
    print(f"{p:25}: {len(v2_fields):2} V2 fields | unmapped: {len(missing)}")
    for l, m in missing:
        print(f"    Unmapped [{l}]: {m}")

print(f"\nTotal V2 fields scanned: {total_fields}, Total unmapped: {total_missing}")
