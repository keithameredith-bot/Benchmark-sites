# benchmark-sites

Code + project knowledge for Benchmark Web Development client WordPress sites. This repo is the
**off-machine copy and history** — it is NOT the editing surface. Edit at the canonical
locations below, then run `sync-to-repo.ps1` and commit.

| Folder | Canonical source |
|---|---|
| `CLAUDE.md` | `C:\Users\keith\Downloads\CLAUDE.md` (shared stack conventions + performance playbook) |
| `jsc/workspace/` | `Desktop\jsc-kadence-mockup\` (build scripts, PROJECT-STATUS.md) |
| `jsc/kadence-child/` | `Local Sites\jsc\...\themes\kadence-child\` (live child theme) |
| `tire-express/workspace/` | `Desktop\tire-express-workspace\` |
| `tire-express/mu-plugins/` | `Local Sites\tire-express\...\mu-plugins\tire-express-custom.php` |
| `fgs/workspace/` | `Desktop\fgs-workspace\` |
| `fgs/mu-plugins/` | `Local Sites\fsg\...\mu-plugins\fgs-*.php` |
| `black-rock/workspace/` | `Desktop\black-rock-workspace\` |
| `black-rock/mu-plugins/` | `Local Sites\black-rock-mortgage\...\mu-plugins\brm-*.php` |

## Workflow (any terminal/session)

1. Work normally in the canonical locations.
2. `powershell -File C:\Users\keith\benchmark-sites\sync-to-repo.ps1`
3. `git add -A && git commit -m "site: what changed"` then push.

## Deliberately excluded

- **Secrets** — credential dotfiles live in `C:\Users\keith\` (`.jsc-rest-auth.txt`,
  `.tire-express-rest-auth.txt`, `.dataforseo-auth`, etc.), outside every synced folder.
- **SQL dumps / AI1WM exports** — backups, not code; contain password hashes.
- **Images, fonts, video** — live in WP uploads / OneDrive; keep the repo lean.
- **Scratch files** — anything starting with `_` (FGS convention).
- **WP core, parent themes, third-party plugins** — restorable, not ours.

Disaster recovery is AI1WM exports + Pressidium backups. This repo recovers the *brains*:
custom code, build scripts, and the PROJECT-STATUS docs.
