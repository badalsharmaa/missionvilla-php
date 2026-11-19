#!/usr/bin/env python3
"""
Validator for content update guides.
Verifies that every 'OLD CONTENT' block extracted from docs/content-update-guides/<slug>.md
appears verbatim inside content/pages/<slug>.php.
"""

import os
import re
import sys
from pathlib import Path

def extract_old_content_blocks(markdown_path):
    with open(markdown_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Pattern: **OLD CONTENT:** followed by optional whitespace and a fenced code block
    # Matches:
    # **OLD CONTENT:**
    # ```text
    # ...
    # ```
    # or **OLD CONTENT (verbatim):** etc.
    pattern = re.compile(
        r'\*\*OLD CONTENT.*?\*\*[:]?\s*```[a-z]*\n(.*?)\n```',
        re.DOTALL
    )

    blocks = []
    for match in pattern.finditer(content):
        old_text = match.group(1)
        # line number of match
        line_num = content[:match.start()].count('\n') + 1
        blocks.append((line_num, old_text))

    return blocks

def verify_page(guide_path, php_path):
    if not php_path.exists():
        return False, [f"PHP source file not found: {php_path}"], 0

    with open(php_path, 'r', encoding='utf-8') as f:
        php_content = f.read()

    blocks = extract_old_content_blocks(guide_path)
    if not blocks:
        return False, ["No OLD CONTENT blocks found in guide."], 0

    errors = []
    for line_num, block in blocks:
        if not block:
            continue
        if block not in php_content:
            # Let's see if stripping trailing spaces helps or if it's genuinely missing
            preview = block[:60] + ('...' if len(block) > 60 else '')
            preview_clean = repr(preview)
            errors.append(f"Line {line_num}: Block not found in PHP: {preview_clean}")

    return len(errors) == 0, errors, len(blocks)

def main():
    repo_root = Path(__file__).resolve().parent.parent
    guides_dir = repo_root / 'docs' / 'content-update-guides'
    pages_php_dir = repo_root / 'content' / 'pages'

    PAGES = [
        'home',
        'living-options',
        'memory-care',
        'respite-care',
        'suites-and-floor-plans',
        'life-at-mission-villa',
        'services-and-amenities',
        'gallery',
        'about',
        'for-families',
        'financial-planning',
        'resources',
        'contact',
    ]

    print("==================================================")
    print("  Mission Villa Content Update Guides Validator   ")
    print("==================================================")

    total_replacements = 0
    all_passed = True
    page_stats = []

    for slug in PAGES:
        guide_file = guides_dir / f"{slug}.md"
        php_file = pages_php_dir / f"{slug}.php"

        if not guide_file.exists():
            print(f"[-] {slug:25s} : MISSING GUIDE FILE")
            all_passed = False
            page_stats.append((slug, "MISSING", 0, ["Guide file does not exist"]))
            continue

        passed, errors, count = verify_page(guide_file, php_file)
        total_replacements += count

        if passed:
            print(f"[✓] {slug:25s} : {count:3d} replacements verified verbatim")
            page_stats.append((slug, "PASSED", count, []))
        else:
            print(f"[X] {slug:25s} : FAILED with {len(errors)} error(s)")
            for err in errors[:5]:
                print(f"      -> {err}")
            if len(errors) > 5:
                print(f"      -> ... and {len(errors) - 5} more errors")
            all_passed = False
            page_stats.append((slug, "FAILED", count, errors))

    print("--------------------------------------------------")
    print(f"Total Verbatim Replacements Verified: {total_replacements}")
    print(f"Overall Status: {'ALL PASSED' if all_passed else 'SOME CHECKS FAILED'}")
    print("==================================================")

    if not all_passed:
        sys.exit(1)

if __name__ == '__main__':
    main()
