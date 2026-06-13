# Make "Claude - <Client>" desktop shortcuts on THIS machine, pointing into this cloned repo.
# Portable: uses its own location, so it works wherever you cloned Benchmark-sites.
# Run:  powershell -ExecutionPolicy Bypass -File make-laptop-shortcuts.ps1
$ErrorActionPreference = 'Stop'
$root = $PSScriptRoot                                  # the cloned repo folder
$wt   = "$env:LOCALAPPDATA\Microsoft\WindowsApps\wt.exe"
$claude = "$env:USERPROFILE\.local\bin\claude.exe"
if (-not (Test-Path $claude)) { $claude = 'claude' }  # fall back to PATH
$desktop = [Environment]::GetFolderPath('Desktop')
$wsh = New-Object -ComObject WScript.Shell

$targets = @(
  @{ Name = 'Claude - FGS';          Dir = Join-Path $root 'fgs\workspace' },
  @{ Name = 'Claude - JSC';          Dir = Join-Path $root 'jsc\workspace' },
  @{ Name = 'Claude - Tire Express'; Dir = Join-Path $root 'tire-express\workspace' },
  @{ Name = 'Claude - Black Rock';   Dir = Join-Path $root 'black-rock\workspace' },
  @{ Name = 'Claude - General';      Dir = $root }
)

foreach ($t in $targets) {
  if (-not (Test-Path $t.Dir)) { Write-Output ("SKIP (missing): " + $t.Dir); continue }
  $lnk = Join-Path $desktop ($t.Name + '.lnk')
  $sc  = $wsh.CreateShortcut($lnk)
  $sc.TargetPath       = $wt
  $sc.Arguments        = '-d "' + $t.Dir + '" cmd /k "' + $claude + '"'
  $sc.WorkingDirectory = $t.Dir
  if (Test-Path "$env:USERPROFILE\.local\bin\claude.exe") { $sc.IconLocation = "$env:USERPROFILE\.local\bin\claude.exe,0" }
  $sc.Description      = 'Open Claude Code in ' + $t.Dir
  $sc.Save()
  Write-Output ("created: " + $lnk)
}
Write-Output "Done. Note: laptop has no LocalWP — these open the docs/scripts for reading + live-site work."
