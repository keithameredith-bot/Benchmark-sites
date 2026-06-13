/* Tire Express pipeline — owned by the Tire Express terminal.
   type: Blog | Location Page | Service Page | Page  status: idea|drafting|ready|scheduled|published|live|open */
window.MC.sites.push({
  id: "te",
  name: "Tire Express",
  short: "TE",
  color: "#1248d7",
  site: "tireexpressandservice.com",
  stage: "Live — rebuild deployed",
  cadence: "2 posts / month",
  traffic: { visits: 608, keywords: 84, note: "" },
  items: [
    // upcoming blog slots (2/month)
    { title: "Open slot — assign topic", type: "Blog", status: "open", date: "2026-06-20", author: "Ben Bishop" },
    { title: "Lift Kit Installation — how big can you go?", type: "Blog", status: "idea", date: "2026-07-04", author: "Ben Bishop", note: "pairs with lift-kit page" },
    { title: "Open slot — assign topic", type: "Blog", status: "open", date: "2026-07-18", author: "Ben Bishop" },
    // page build queue
    { title: "Lift Kit Installation page", type: "Service Page", status: "idea", date: "", note: "candidate service page" },
    // shipped
    { title: "Florida Heat & Your Tires", type: "Blog", status: "live", date: "", author: "Ben Bishop", note: "strong long-form" },
    { title: "A/C Recharge explainer", type: "Blog", status: "live", date: "", author: "Ben Bishop" },
    { title: "Tire Rotation guide", type: "Blog", status: "live", date: "", author: "Ben Bishop" },
    { title: "Service pages ×14 + home/about/contact/gallery (Divi→Kadence rebuild)", type: "Service Page", status: "live", date: "", note: "full rebuild live" }
  ]
});
