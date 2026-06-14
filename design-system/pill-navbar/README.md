# Pill Navbar — the FGS floating menu, reusable

The exact floating white-pill navbar from FGS: rounded pill over the page, logo + links + an inverting
**Call Now** CTA, animated underline links, **no shrink on scroll**, card dropdown, dark mobile drawer.

## Point a terminal here
> Apply the Benchmark pill navbar to this site. Open
> `C:\Users\keith\benchmark-sites\design-system\pill-navbar\apply-pill-navbar.php`, edit the CONFIG block
> at the top to this site's brand colors + logo height, then run it against the local site:
> `& "C:\Users\keith\.hermes\git\bin\bash.exe" -c 'source ~/Desktop/<site>-workspace/wp-env.sh && wp eval-file "C:/Users/keith/benchmark-sites/design-system/pill-navbar/apply-pill-navbar.php"'`
> Then verify the header has a Button element ("Call Now", tel: link) in the main row, and hard-refresh.

## What it does
- Writes a marker-guarded block to **Additional CSS** (idempotent — re-run anytime).
- Turns Kadence **sticky-shrink OFF** and sticky main-row ON (the no-jump float).
- Pure CSS + two theme-mods. No child-theme or plugin needed.

## Prerequisites
- Kadence + Kadence Pro (sticky header).
- Header MAIN row contains **logo + navigation + a Button** (the Button is the Call Now CTA the CSS
  styles via `.header-button`). Add it in Customize → Header if missing.
- A custom logo set.

## Customize per site
Edit the CONFIG block: `$accent` (brand color), `$ink` (link/drawer), `$blush` (dropdown hover),
`$active_dark` (current item on the dark drawer), logo heights, CTA shadow tone. Everything else is
neutral chrome you can leave alone.

## Want it floating over a colored hero (like FGS)?
See the OPTIONAL block at the bottom of the PHP — it makes the header transparent and overlays the hero.
