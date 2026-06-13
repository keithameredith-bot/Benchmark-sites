/* JSC Contracting pipeline — owned by the JSC terminal.
   type: Blog | Location Page | Service Page | Page  status: idea|drafting|ready|scheduled|published|live|open */
window.MC.sites.push({
  id: "jsc",
  name: "JSC Contracting",
  short: "JSC",
  color: "#b8860b",
  site: "jscfla.com",
  stage: "Paused — pre-launch (awaiting Alex's pricing)",
  cadence: "2 posts / month (starts at launch)",
  gbp: "2 GBP posts / week + 1 per blog publish",
  traffic: { visits: 1406, keywords: 68, note: "current site; rebuild pre-launch" },
  items: [
    // blog slots (start at launch — tentative)
    { title: "Open slot — assign topic (post-launch)", type: "Blog", status: "open", date: "2026-07-01", author: "" },
    { title: "Open slot — assign topic (post-launch)", type: "Blog", status: "open", date: "2026-07-15", author: "" },
    // page build queue
    { title: "Floor Plans We Build (blueprint aesthetic)", type: "Page", status: "drafting", date: "", note: "active build-out" },
    { title: "Barndominium lead-magnet / affiliate angle", type: "Page", status: "idea", date: "", note: "" },
    // shipped (rebuild work)
    { title: "Service pages + galleries (Divi→Kadence rebuild)", type: "Service Page", status: "live", date: "", note: "rebuild done; launch paused on pricing" }
  ]
});
