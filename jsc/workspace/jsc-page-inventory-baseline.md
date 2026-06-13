# JSC Contracting — Pre-Migration Page Inventory & Baseline

**Captured:** 2026-06-09, from **live** `jscfla.com` (rendered `<head>` via curl — authoritative; the LocalWP copy is an import of this). This is the **protect-this** snapshot: after each page is rebuilt in Kadence, its URL, title, H1, and self-canonical must match this (copy substantially the same) unless a change is deliberate + 301'd.

**33 URLs total** (28 pages + 5 posts). ✅ **All canonicals are self-referential** — no existing spoke→pillar canonical issues.

---

## Service pages (migration targets — protect rankings)

| URL (slug) | Title tag | H1 | Canonical |
|---|---|---|---|
| `/barndominium-builders-in-florida/` ⭐#1–2 | Barndominium Builders in Florida - JSC Contracting Inc | ⚠️ see flag (misspelled hero H1) | self ✓ |
| `/central-florida-dock-builder/` | Central Florida Dock Builder - JSC Contracting Inc | Central Florida Dock Builder | self ✓ |
| `/boathouse-builder/` | Central Florida Boathouse Builder - JSC Contracting Inc | Central Florida Boathouse Builder | self ✓ |
| `/seawall-construction-and-repair/` | Seawall Construction and Repair - JSC Contracting Inc | Florida Seawall Construction and Repair | self ✓ |
| `/central-florida-boat-lift-installation/` | Central Florida Boat Lift Installation - JSC Contracting Inc | Central Florida Boat Lift Installation | self ✓ |
| `/pole-barn-builder/` | Pole Barn Builder in Central Florida - JSC Contracting Inc | Pole Barn Builder in Central Florida | self ✓ |
| `/home-remodeling-central-florida/` | Home Remodeling Central Florida - JSC Contracting Inc | Home Remodeling Central Florida | self ✓ |
| `/custom-new-construction-builder-in-central-florida/` | Custom New Construction Builder in Central Florida - JSC | Custom New Construction Builder in Central Florida | self ✓ |
| `/central-florida-fence-builder-2/` → **CHANGED 2026-06-09 to `/central-florida-fence-builder/` + 301** (Keith-approved; attachment held the clean slug) | Central Florida Fence Builder - JSC Contracting Inc | Central Florida's Best Fence Builder → rebuilt with "Central Florida Fence Builder" (pending Keith's call) | self ✓ |

## Main / info pages

| URL | Title | H1 | Canonical |
|---|---|---|---|
| `/` (home) | JSC Contracting Inc, Marine and Residential Construction | JSC Contracting Inc. | self ✓ |
| `/services/` | Services - JSC Contracting Inc | Our Services | self ✓ |
| `/about-us/` | About us - JSC Contracting Inc | About us | self ✓ |
| `/our-team/` | Our Team - JSC Contracting Inc | JSC Contracting Management Team | self ✓ |
| `/core-values/` | JSC Contracting — Core Values | ⚠️ EMPTY H1 | self ✓ |
| `/our-reviews/` | Our Reviews - JSC Contracting Inc | Our Reviews | self ✓ |
| `/contact/` | Contact - JSC Contracting Inc | Contact us | self ✓ |
| `/thank-you/` | Thank you - JSC Contracting Inc | Thank you | self ✓ |
| `/privacy-policy-2/` | Privacy Policy - JSC Contracting Inc | Privacy Policy | self ✓ |

## Gallery pages

| URL | Title | H1 | Canonical |
|---|---|---|---|
| `/galleries/` | Galleries - JSC Contracting Inc | Galleries of Our Past Work | self ✓ |
| `/barndominium-gallery/` ⭐#1 | Barndominium Gallery - JSC Contracting Inc | Barndominium Gallery | self ✓ |
| `/dock-gallery/` | Dock Gallery - JSC Contracting Inc | ⚠️ "Boathouse Gallery" (WRONG) | self ✓ |
| `/boathouse-gallery/` | Boathouse Gallery - JSC Contracting Inc | Boathouse Gallery | self ✓ |
| `/seawall-gallery/` | Seawall Gallery - JSC Contracting Inc | Seawall Gallery | self ✓ |
| `/pole-barn-gallery/` | Pole Barn Gallery - JSC Contracting Inc | Pole Barn Gallery | self ✓ |
| `/new-fencing-gallery/` | New Fencing Gallery - JSC Contracting Inc | New Fencing Gallery | self ✓ |
| `/new-home-gallery/` | New Home Gallery - JSC Contracting Inc | New Home Gallery | self ✓ |
| `/marine-construction-gallery/` → **CONSOLIDATED 2026-06-09: 301 → `/galleries/`** (redundant; all photos duplicated in other galleries) | Marine Construction Gallery - JSC Contracting Inc | — | — |

## Blog

| URL | Title | H1 | Canonical |
|---|---|---|---|
| `/blog/` | Blog - JSC Contracting Inc | Blog | self ✓ |
| `/blog/building-a-dock-on-lake-george-florida/` | Building a Dock on Lake George FL — Wind, Waves & What It Takes \| JSC Contracting | Building a Dock on Lake George FL — Wind, Waves & What It Takes | self ✓ |
| `/blog/fence-installation-in-central-florida-2026/` | Fence Installation Central Florida 2026 — Costs & Best Materials \| JSC Contracting | Fence Installation in Central Florida: Which Material Actually Lasts and What It Costs in 2026 | self ✓ |
| `/blog/barndominium-cost-central-florida-2026/` | Barndominium Cost in Central Florida 2026 — Real Builder Pricing | What Does It Actually Cost to Build a Barndominium in Central Florida in 2026? | self ✓ |
| `/blog/blog-central-florida-seawall-inspection-checklist-7-signs.../` | Central Florida Seawall Inspection Checklist: 7 Signs… | Central Florida Seawall Inspection Checklist: 7 Signs Your Seawall Won't Survive the 2026 Hurricane Season | self ✓ |
| `/blog/dock-builder-near-me/` → **CONSOLIDATED 2026-06-09: 301 → `/central-florida-dock-builder/`** (article body lost pre-migration; "near me" intent belongs to the service page) | Dock Builder Near Me - JSC Contracting- Central Florida | — | — |

> Note: the seawall blog slug is the awkward `blog-central-florida-seawall-inspection-checklist-7-signs-your-seawall-wont-survive-the-2026-hurricane-season` (has a redundant `blog-` prefix). Leave as-is to protect it, or 301 if Keith wants it cleaned.

---

## ⚠️ Issues found (fix during rebuild — most are SEO upside, low risk)

1. **`/dock-gallery/` has the WRONG H1: "Boathouse Gallery"** (copy-paste error). Title is correct ("Dock Gallery"). Fix H1 → **"Dock Gallery"** on rebuild. *(Confirm with Keith — H1 change, but it's clearly an error and the title/slug already say Dock.)*
2. **`/barndominium-builders-in-florida/` H1 is misspelled** — the visible hero H1 reads **"We Are The Best *Bardominium* Builders in Florida"** (curl also surfaced a correctly-spelled "Barndominium Builders in Florida" — so the page likely has **conflicting/multiple H1s**). On rebuild: **single, correctly-spelled H1** with the keyword "Barndominium." Pure SEO upside (this is the #1–2 page — change the spelling, keep the keyword + intent).
3. **`/core-values/` has an EMPTY H1.** Add a real H1 (e.g., "Our Core Values" / the CONQUER line) on rebuild.
4. **Home meta description has a double comma:** "…barndominiums,, new fencing…". Trivial fix.
5. **Missing/auto-generated meta descriptions** (AIOSEO is auto-filling from body text) on: `/seawall-construction-and-repair/`, `/about-us/`, `/contact/`, `/thank-you/`, `/blog/`. Write proper meta descriptions on rebuild (low risk, CTR upside).
6. Hermes already flagged additional body/H2 misspellings on the barndominium page (Bardominium/Barndomimium, "one our architects", etc.) and a wrong-client **"plumbing" CTA** — see `PROJECT-STATUS.md` §COPY. Apply those fixes too.

## Protection rules (per PROJECT-STATUS.md)

For every rebuilt page: **slug byte-identical** · **body copy substantially the same** (keep keyword paragraphs/word count) · **title tag preserved** (improve only deliberately) · **H1 preserved** (except the documented error/spelling fixes) · **self-canonical** · galleries/spokes never canonical to siblings or home. 301 anything that must change.
