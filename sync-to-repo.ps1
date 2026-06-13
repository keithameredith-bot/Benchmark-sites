# Sync canonical sources into this repo. Run BEFORE every commit, from any terminal.
# Canonical locations stay where they are (LocalWP site folders + Desktop workspaces);
# this repo is the off-machine copy + history, never the editing surface.
$repo = "C:\Users\keith\benchmark-sites"
$rc = @("/MIR", "/NJH", "/NJS", "/NDL", "/NFL",
    "/XF", "*.sql", "*.wpress", "*.zip", "*.png", "*.webp", "*.jpg", "*.jpeg",
    "*.ttf", "*.pdf", "*.mov", "*.mp4", "_*",
    "/XD", "_*", ".git")

# conventions now canonical at the global ~/.claude/CLAUDE.md (auto-loads in every session)
Copy-Item "C:\Users\keith\.claude\CLAUDE.md" "$repo\CLAUDE.md" -Force

robocopy "C:\Users\keith\Desktop\jsc-kadence-mockup" "$repo\jsc\workspace" @rc | Out-Null
robocopy "C:\Users\keith\Local Sites\jsc\app\public\wp-content\themes\kadence-child" "$repo\jsc\kadence-child" @rc | Out-Null
robocopy "C:\Users\keith\Desktop\tire-express-workspace" "$repo\tire-express\workspace" @rc | Out-Null
robocopy "C:\Users\keith\Desktop\fgs-workspace" "$repo\fgs\workspace" @rc | Out-Null
robocopy "C:\Users\keith\Desktop\black-rock-workspace" "$repo\black-rock\workspace" @rc | Out-Null
robocopy "C:\Users\keith\Desktop\north-fl-container-workspace" "$repo\nfc\workspace" @rc | Out-Null

# custom mu-plugins only (Pressidium/Local infrastructure files are not ours)
New-Item -ItemType Directory -Force "$repo\tire-express\mu-plugins" | Out-Null
Copy-Item "C:\Users\keith\Local Sites\tire-express\app\public\wp-content\mu-plugins\tire-express-custom.php" "$repo\tire-express\mu-plugins\" -Force
New-Item -ItemType Directory -Force "$repo\fgs\mu-plugins" | Out-Null
Copy-Item "C:\Users\keith\Local Sites\fsg\app\public\wp-content\mu-plugins\fgs-*.php" "$repo\fgs\mu-plugins\" -Force
New-Item -ItemType Directory -Force "$repo\black-rock\mu-plugins" | Out-Null
Copy-Item "C:\Users\keith\Local Sites\black-rock-mortgage\app\public\wp-content\mu-plugins\brm-*.php" "$repo\black-rock\mu-plugins\" -Force

Write-Host "sync complete"
exit 0
