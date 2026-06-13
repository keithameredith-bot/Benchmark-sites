# Mission Control — Roadmap

Your feature ideas, triaged. Built incrementally from the **Claude - Mission Control** terminal.

## ✅ Done
- Per-site pipeline boards (posts vs location/service/other pages)
- Publishing schedule with target dates, driven by each site's cadence
- DataForSEO traffic per site (organic visits + ranked keyword count)
- **Performance & Opportunities** per site: top organic pages + low-hanging-fruit keywords (#4–15)
- Draft links — click a card title to open/approve (FGS draft edit links wired)
- GBP + social cadence visible per site
- Name corrected to Benchmark Web Development

## 🔜 Next (high value, architecture-friendly)
1. **Promotion track** — per-site lane for GBP posts + social, with the 2/week recurring cadence and
   auto-generated "GBP post for <blog title>" tasks when a post is scheduled. (Combines social here
   rather than a separate calendar.)
2. **Needs-Refresh section** — pull each published page's `post_modified` (WP REST/CLI) and flag
   anything cornerstone older than 6–12 months, per the refresh policy.
3. **"This week" strip** — a cross-site top banner of everything due in the next 7 days, so the
   first thing you see is what's next regardless of site.
4. **One-click GBP blurb** — when a post publishes, Claude drafts the GBP post text + suggests a photo.

## 🤔 Considered — tradeoffs to decide
- **Buttons that move a card (drafting → scheduled) by clicking.** Honest limitation: the board is a
  static file opened from disk, so a click can't *save* a change — there's no server behind it. Two
  options if you want true click-to-edit: (a) keep today's model — you say "move X to scheduled" and
  Claude edits the file (zero maintenance, works on any machine, syncs via git); or (b) run a tiny
  local server with a save API (a real app — more power, but a process to keep running and it breaks
  the "double-click a file / syncs via git" simplicity). **Recommendation: stay with (a)** unless the
  volume ever makes conversational edits feel slow.
- **Auto-refresh of performance data.** Could schedule the DataForSEO pull (Windows Task Scheduler or
  a cron-like routine) instead of monthly-by-hand. Worth it once the routine is habit.

## How to extend
Each feature is a small change to `index.html` (render) + the per-site `data/*.js` (content) and/or
`pull-performance.py` (data). Tell the Mission Control terminal which roadmap item to build next.
