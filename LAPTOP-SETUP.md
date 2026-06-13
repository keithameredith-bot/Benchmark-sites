# Laptop Setup — Benchmark sites (clone-and-go)

Goal: get a second machine working on the **live** sites (Black Rock, Tire Express) and able to
read/plan every project. Build work on not-yet-launched sites (FGS, JSC) still needs LocalWP on the
machine that has it — the laptop is for live-site work + planning.

## 1. Install the tools
- **Claude Code** (same as desktop). After install, `claude.exe` should be at
  `C:\Users\<you>\.local\bin\claude.exe` (the shortcuts look there; they fall back to PATH).
- **Git** (to clone this repo).
- **Windows Terminal** (the shortcuts launch it; it's on Win11 by default).

## 2. Clone this repo
Open a terminal and:
```
git clone https://github.com/keithameredith-bot/Benchmark-sites.git
```
Clone it wherever you like (e.g. `C:\Users\<you>\Benchmark-sites` or a Desktop folder).
That gives you every client's docs, scripts, and custom mu-plugins — version-controlled.
Pull the latest anytime with `git pull`.

## 3. Make the shared conventions auto-load
Copy the repo's root `CLAUDE.md` to the global Claude location so it loads in every session:
```
copy CLAUDE.md "%USERPROFILE%\.claude\CLAUDE.md"
```

## 3b. Install the skills (e.g. the `new-site` skill)
```
xcopy /E /I /Y skills "%USERPROFILE%\.claude\skills"
```
Then `/new-site` is available in any terminal for spinning up a from-scratch build.
(Create the `.claude` folder first if it doesn't exist.)

## 4. Copy your secrets by hand (NOT in the repo, NOT in OneDrive)
These live in `C:\Users\keith\` on the desktop and are needed for live-site work. Copy the ones you
need to the same spot on the laptop (`C:\Users\<you>\`):
- `.pressidium-sftp.txt` (SFTP creds for all three Pressidium sites)
- `.black-rock-rest-auth.txt` (Black Rock REST API)
- `.dataforseo-auth` / `dfs-auth.txt` (keyword research)
- `.n8n-api.txt` (lead automations)
- the SFTP client `psftp.exe` (Black Rock CLAUDE.md references `C:\Users\keith\.tools\psftp.exe`)

## 5. Make desktop shortcuts (one per client)
From the cloned repo folder, run:
```
powershell -ExecutionPolicy Bypass -File make-laptop-shortcuts.ps1
```
It finds its own location and makes "Claude - <Client>" shortcuts on your Desktop, each opening
Windows Terminal in that client's folder inside the clone, running Claude. Re-run after `git pull`
if paths change.

## What works on the laptop vs not
- ✅ Black Rock + Tire Express: full live-site work (content via REST, files/options via SFTP).
- ✅ Reading/planning/writing for all four clients (docs + scripts are here).
- ❌ FGS + JSC build work that drives LocalWP/WP-CLI — needs the machine with LocalWP installed.
- ❌ Claude's *memory* from the desktop doesn't travel — the PROJECT-STATUS.md in each workspace is
  how a fresh session gets caught up (that's what it's for).
