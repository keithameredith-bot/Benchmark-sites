/* FGS pipeline — owned by the FGS terminal.
   type: Blog | Location Page | Service Page | Page
   status: idea | drafting | ready | scheduled | published | live | open
   date: ISO publish/target date or ""   url: optional link to open/approve (local edit links work only on the LocalWP machine) */
window.MC.sites.push({
  id: "fgs",
  name: "Florida Geotechnical Services",
  short: "FGS",
  color: "#a91513",
  site: "floridageotechnicalservices.com",
  stage: "Pre-launch — staging review pending",
  cadence: "2 posts / month",
  gbp: "2 GBP posts / week + 1 per blog publish",
  traffic: { visits: 28, keywords: 25, note: "current Astro site (new build not live yet)" },
  items: [
    { title: "Do You Need Soil Testing for a Building Permit? (county-by-county)", type: "Blog", status: "scheduled", date: "2026-06-27", author: "Ryan Townsend", note: "tentative — pending launch" },
    { title: "Sinkhole Alley, Explained (Citrus / Hernando / Sumter / Marion)", type: "Blog", status: "scheduled", date: "2026-07-11", author: "Dave Cappa, P.E.", note: "pairs with Citrus location page" },
    { title: "SPT Borings vs. CPT: Which Test Does Your Project Need?", type: "Blog", status: "idea", date: "2026-07-25", author: "Dave Cappa, P.E.", note: "" },
    { title: "What GPR Can and Can't Find (Honest Guide)", type: "Blog", status: "idea", date: "2026-08-08", author: "Dave Cappa, P.E.", note: "honest-limits angle" },
    { title: "How Much Does a Geotechnical Report Cost in Florida? (2026)", type: "Blog", status: "published", date: "2026-06-12", author: "Ryan Townsend", note: "cornerstone cost guide", url: "http://fsg.local/?p=586&preview=true" },
    { title: "Sinkhole Warning Signs in Florida: What's Serious", type: "Blog", status: "published", date: "2026-06-12", author: "Dave Cappa, P.E.", url: "http://fsg.local/?p=587&preview=true" },
    { title: "Gainesville & Alachua County", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=444&action=edit" },
    { title: "The Villages", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=445&action=edit" },
    { title: "Sumter County", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=446&action=edit" },
    { title: "Citrus County (sinkhole-led)", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=447&action=edit" },
    { title: "Lake County", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=448&action=edit" },
    { title: "Putnam County", type: "Location Page", status: "drafting", date: "", note: "draft built — awaiting review", url: "http://fsg.local/wp-admin/post.php?post=449&action=edit" },
    { title: "Reviews & Testimonials", type: "Page", status: "drafting", date: "", note: "needs 4 GBP reviews + permission", url: "http://fsg.local/wp-admin/post.php?post=589&action=edit" },
    { title: "Service pages ×10 (geotech, sinkhole, drilling, soil lab, CMT, GPR, ESA, pavement, foundation, concrete/asphalt)", type: "Service Page", status: "published", date: "", note: "built — live on staging" },
    { title: "Core pages (Home, About, Mission, Contact, Free-Quote, Gallery)", type: "Page", status: "published", date: "", note: "built — live on staging" }
  ]
});
