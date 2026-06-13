#!/bin/bash
# JSC migration full verification sweep — run in git-bash. Compares every page against the
# protected baseline: HTTP 200, exactly one correct H1, self-canonical, meta description, broken images, 301s.
BASE="http://jsc.local"

declare -A H1S=(
  ["/"]="JSC Contracting Inc."
  ["/services/"]="Our Services"
  ["/get-a-free-quote/"]="Get Your Free Quote"
  ["/barndominium-builders-in-florida/"]="Barndominium Builders in Florida"
  ["/central-florida-dock-builder/"]="Central Florida Dock Builders"  # pluralized 2026-06-10, Keith-approved (DataForSEO push)
  # 2026-06-10 Keith-approved DataForSEO tweaks: pluralized/intent-added H1s below
  ["/boathouse-builder/"]="Central Florida Boathouse Builders"
  ["/seawall-construction-and-repair/"]="Florida Seawall Construction and Repair"
  ["/central-florida-boat-lift-installation/"]="Central Florida Boat Lift Installation &#038; Repair"
  ["/pole-barn-builder/"]="Pole Barn Builders in Central Florida"
  ["/home-remodeling-central-florida/"]="Home Remodeling Central Florida"
  ["/custom-new-construction-builder-in-central-florida/"]="Custom Home Builders in Central Florida"
  ["/central-florida-fence-builder/"]="Central Florida Fence Builders"
  ["/container-home-builders-in-florida/"]="Container Home Builders in Florida"
  ["/galleries/"]="Galleries of Our Past Work"
  ["/barndominium-gallery/"]="Barndominium Gallery"
  ["/dock-gallery/"]="Dock Gallery"
  ["/boathouse-gallery/"]="Boathouse Gallery"
  ["/seawall-gallery/"]="Seawall Gallery"
  ["/pole-barn-gallery/"]="Pole Barn Gallery"
  ["/new-fencing-gallery/"]="New Fencing Gallery"
  ["/new-home-gallery/"]="New Home Gallery"
  ["/about-us/"]="About us"
  ["/our-team/"]="JSC Contracting Management Team"
  ["/core-values/"]="Our Core Values"
  ["/our-reviews/"]="Our Reviews"
  ["/contact/"]="Contact us"
  ["/thank-you/"]="Thank you"
  ["/privacy-policy-2/"]="Privacy Policy"
)
# blog posts: H1 = entry title from theme
declare -A POSTS=(
  ["/blog/barndominium-cost-central-florida-2026/"]="What Does It Actually Cost to Build a Barndominium in Central Florida in 2026?"
  ["/blog/fence-installation-in-central-florida-2026/"]="Fence Installation in Central Florida: Which Material Actually Lasts and What It Costs in 2026"
  ["/blog/building-a-dock-on-lake-george-florida/"]="Building a Dock on Lake George FL — Wind, Waves &amp; What It Takes"
  ["/blog/dock-cost-central-florida-2026/"]="What Does a Dock Cost in Central Florida? Real 2026 Builder Pricing"
)
REDIRECTS=(
  "/central-florida-fence-builder-2/|/central-florida-fence-builder/"
  "/blog/dock-builder-near-me/|/central-florida-dock-builder/"
  "/marine-construction-gallery/|/galleries/"
)

fail=0
check_page () {
  local path="$1" want_h1="$2"
  local html code h1c h1 canon desc broken=0
  html=$(curl -s "$BASE$path")
  code=$(curl -s -o /dev/null -w "%{http_code}" "$BASE$path")
  h1c=$(echo "$html" | grep -oE "<h1[^>]*>" | wc -l)
  h1=$(echo "$html" | grep -oE "<h1[^>]*>[^<]*</h1>" | sed -E 's/<[^>]*>//g' | head -1)
  canon=$(echo "$html" | grep -oE 'rel="canonical" href="[^"]*"' | sed 's/.*href="//;s/"//')
  desc=$(echo "$html" | grep -cE '<meta name="description"')
  for img in $(echo "$html" | grep -oE 'src="[^"]*uploads[^"]*"' | sed 's/src="//;s/"//' | sort -u | head -40); do
    [[ "$img" == http* ]] || img="$BASE$img"
    [ "$(curl -s -o /dev/null -w "%{http_code}" "$img")" != "200" ] && broken=$((broken+1))
  done
  local st="OK"
  [ "$code" != "200" ] && st="FAIL http=$code"
  [ "$h1c" != "1" ] && st="FAIL h1count=$h1c"
  [ "$h1" != "$want_h1" ] && st="FAIL h1='$h1'"
  [ "$canon" != "$BASE$path" ] && st="FAIL canon=$canon"
  [ "$desc" == "0" ] && [ "$path" != "/thank-you/" ] && st="$st WARN-no-meta-desc"
  [ "$broken" != "0" ] && st="$st BROKEN-IMGS=$broken"
  [[ "$st" != OK* ]] && fail=1
  printf "%-12s %s\n" "$st" "$path"
}

echo "===== PAGES ====="
for p in "${!H1S[@]}"; do check_page "$p" "${H1S[$p]}"; done
echo "===== POSTS ====="
for p in "${!POSTS[@]}"; do check_page "$p" "${POSTS[$p]}"; done
echo "===== REDIRECTS ====="
for r in "${REDIRECTS[@]}"; do
  src="${r%%|*}"; dst="${r##*|}"
  got=$(curl -s -o /dev/null -w "%{http_code} %{redirect_url}" "$BASE$src")
  if [[ "$got" == "301 $BASE$dst" ]]; then echo "OK           $src -> $dst"; else echo "FAIL         $src got: $got"; fail=1; fi
done
echo "====="
[ $fail -eq 0 ] && echo "ALL CHECKS PASSED" || echo "FAILURES PRESENT — see above"
