/* Black Rock Mortgage pipeline — owned by the Black Rock terminal.
   This is a SCAFFOLD from what the FGS terminal knew; the BR terminal should replace the
   open slots / add real topics from EDITORIAL-CALENDAR.md + CONTENT-PLAN-LENDER-NICHES.md.
   type: Blog | Location Page | Service Page | Page   status: idea|drafting|ready|scheduled|published|live|open */
window.MC.sites.push({
  id: "brm",
  name: "Black Rock Mortgage",
  short: "BRM",
  color: "#049F82",
  site: "blackrockmortgage.com",
  stage: "Live — content engine running",
  cadence: "1 post / week",
  traffic: { visits: 1731, keywords: 999, note: "strongest domain" },
  items: [
    // weekly cadence slots — BR terminal to assign real topics
    { title: "Open slot — assign topic (see EDITORIAL-CALENDAR.md)", type: "Blog", status: "open", date: "2026-06-18", author: "" },
    { title: "Open slot — assign topic", type: "Blog", status: "open", date: "2026-06-25", author: "" },
    { title: "Open slot — assign topic", type: "Blog", status: "open", date: "2026-07-02", author: "" },
    { title: "Open slot — assign topic", type: "Blog", status: "open", date: "2026-07-09", author: "" },
    // lender-niche page pipeline (build queue, 2/wk per content plan)
    { title: "Lender-niche pages (224-lender pipeline, 2/wk)", type: "Service Page", status: "scheduled", date: "", note: "from CONTENT-PLAN-LENDER-NICHES.md — anti-mill" },
    // recently shipped (known)
    { title: "Florida first-time home buyer grants", type: "Blog", status: "published", date: "2026-06-11", note: "hedged figures — sanity-check" },
    { title: "Rent-to-own / requirements-to-buy / property-tax exemptions", type: "Blog", status: "published", date: "2026-06-11", note: "P3 content-gap set" },
    { title: "City service-area pages (Villages, Gainesville, Belleview)", type: "Location Page", status: "published", date: "", note: "distinct angles + internal links" }
  ]
});
