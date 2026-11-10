#!/usr/bin/env python3
"""Build the header logo derivatives from the official Mission Villa artwork.

Canonical source: resources/brand/mission-villa-logo-honor.png (1342x999, transparent),
copied unchanged from the React reference public/brand/ (official client logo).

The header lockup is a *rearrangement* of the official pixels, never a redraw:
  - leaf emblem          (source rows 29-597)   -> placed left, scaled uniformly
  - MissionVilla wordmark (source rows 602-771)  -> unchanged
  - Senior Living + rules (source rows 797-856)  -> unchanged
  - tagline              (source rows 883-952)  -> omitted (illegible at header size)
Letterforms, spacing and proportions inside each piece are untouched; every piece is
scaled with the same uniform factor except the leaf, which is scaled uniformly on its own.

Outputs (public/images/brand/):
  mission-villa-logo-header-light.webp  ivory wordmark + pale sage subtitle, colour leaf, gold rules
                                        -> for dark backgrounds (the site header is always dark)
  mission-villa-logo-header-colour.webp official colours -> for light backgrounds

Run:  python3 resources/brand/build-header-logo.py
"""
from pathlib import Path

import numpy as np
from PIL import Image

ROOT = Path(__file__).resolve().parents[2]
SRC = ROOT / "resources/brand/mission-villa-logo-honor.png"
OUT = ROOT / "public/images/brand"

LEAF = (377, 29, 1071, 598)        # x0, y0, x1, y1 (exclusive)
TEXT = (0, 600, 1342, 860)         # wordmark + subtitle band, full width
SUB_ROWS = (797 - TEXT[1], 857 - TEXT[1])  # subtitle rows inside TEXT crop
SUB_TEXT_X = (250, 1105)           # "SENIOR LIVING" letters (rules sit outside this span)

IVORY = (249, 245, 240)            # --text-ivory
SAGE = (214, 224, 203)             # light tint of the official subtitle green

LEAF_SCALE_TO_TEXT = 1.06          # leaf height relative to the text band
GAP = 34                           # px at source scale between leaf and text
EXPORT_HEIGHT = 168                # ~3x the largest display height (56px)


def tight(img: Image.Image) -> Image.Image:
    return img.crop(img.getbbox())


def clean_alpha(img: Image.Image, floor: int = 24) -> Image.Image:
    """Drop the near-invisible halo specks left by the original background removal."""
    a = np.array(img)
    a[a[..., 3] < floor] = 0
    return Image.fromarray(a)


def recolour_light(text: Image.Image) -> Image.Image:
    a = np.array(text).astype(np.uint8)
    h = a.shape[0]
    s0, s1 = SUB_ROWS
    word = np.zeros(a.shape[:2], bool)
    word[:s0] = True
    sub = np.zeros(a.shape[:2], bool)
    sub[s0:s1, SUB_TEXT_X[0]:SUB_TEXT_X[1]] = True
    vis = a[..., 3] > 0
    a[word & vis, :3] = IVORY
    a[sub & vis, :3] = SAGE
    # Rules stay gold; anything dark left in the rule zone is fringe ink -> ivory.
    rule_zone = np.zeros(a.shape[:2], bool)
    rule_zone[s0:s1] = True
    rule_zone &= ~sub
    dark = a[..., :3].max(axis=2) < 140
    a[rule_zone & vis & dark, :3] = IVORY
    return Image.fromarray(a)


def build(light: bool) -> Image.Image:
    src = clean_alpha(Image.open(SRC).convert("RGBA"))
    leaf = tight(src.crop(LEAF))
    text = src.crop(TEXT)
    if light:
        text = recolour_light(text)
    text = tight(text)

    lh = round(text.height * LEAF_SCALE_TO_TEXT)
    lw = round(leaf.width * lh / leaf.height)
    leaf = leaf.resize((lw, lh), Image.LANCZOS)

    w = lw + GAP + text.width
    h = max(lh, text.height)
    canvas = Image.new("RGBA", (w, h), (0, 0, 0, 0))
    canvas.alpha_composite(leaf, (0, (h - lh) // 2))
    canvas.alpha_composite(text, (lw + GAP, (h - text.height) // 2))

    ew = round(w * EXPORT_HEIGHT / h)
    return canvas.resize((ew, EXPORT_HEIGHT), Image.LANCZOS)


if __name__ == "__main__":
    OUT.mkdir(parents=True, exist_ok=True)
    for name, light in (("light", True), ("colour", False)):
        img = build(light)
        path = OUT / f"mission-villa-logo-header-{name}.webp"
        img.save(path, "WEBP", quality=92, method=6)
        print(path.relative_to(ROOT), img.size)
