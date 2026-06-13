/* Black Rock Mortgage pipeline — owned by the Black Rock terminal.
   Sources: EDITORIAL-CALENDAR.md + CONTENT-PLAN-LENDER-NICHES.md (Desktop\black-rock-workspace).
   type: Blog | Location Page | Service Page | Page   status: idea|drafting|ready|scheduled|published|live|open
   date: ISO publish/target date or "" */
window.MC.sites.push({
  id: "brm",
  name: "Black Rock Mortgage",
  short: "BRM",
  color: "#049F82",
  site: "blackrockmortgage.com",
  stage: "Live — content engine running",
  cadence: "1 post/week (blog) + 2/wk niche-page build queue",
  gbp: "2 GBP posts / week + 1 per blog publish",
  social: "Facebook + Instagram (BRM does social)",
  traffic: { visits: 1731, keywords: 999, note: "strongest domain; USDA cluster pos 7-20" },
  items: [
    // —— Blog: SCHEDULED in WP (auto-publish, status=future), 2/wk launch run ——
    { title: "The Cheapest Places to Buy a House in Florida (2026)", type: "Blog", status: "scheduled", date: "2026-06-15", author: "Keith Meredith" },
    { title: "Florida First-Time Home Buyer Grants & Programs (2026)", type: "Blog", status: "scheduled", date: "2026-06-18", author: "Keith Meredith", note: "Hometown Heroes figures corrected (occupation-restricted)" },
    { title: "Rent-to-Own Homes in Florida", type: "Blog", status: "scheduled", date: "2026-06-22", author: "Keith Meredith", note: "add Geo-Corp EEP lease-purchase section post-pub" },
    { title: "Requirements to Buy a House in Florida (2026)", type: "Blog", status: "scheduled", date: "2026-06-25", author: "Keith Meredith" },
    { title: "Florida Property Tax Exemptions (2026)", type: "Blog", status: "scheduled", date: "2026-06-29", author: "Keith Meredith" },
    { title: "How Much House Can I Afford in Florida? The Real Math", type: "Blog", status: "scheduled", date: "2026-07-02", author: "Keith Meredith", note: "pairs with affordability calculator" },
    { title: "FHA vs USDA vs VA vs Conventional in Florida", type: "Blog", status: "scheduled", date: "2026-07-06", author: "Keith Meredith", note: "decision article → all 4 program pages" },

    // —— Blog: upcoming ideas (editorial calendar Month 1-3, ~1/wk after Jul 6) ——
    { title: "Florida Mortgage Rates: What Actually Moves Them", type: "Blog", status: "idea", date: "2026-07-13", author: "Keith Meredith", note: "monthly refresh + LLM-citation play" },
    { title: "Best Places to Retire in Florida on a Budget", type: "Blog", status: "idea", date: "2026-07-20", author: "Keith Meredith", note: "reverse + property-tax funnel" },
    { title: "Buying a Florida Vacation / Second Home", type: "Blog", status: "idea", date: "", author: "Keith Meredith", note: "second-home + condotel funnel" },
    { title: "Florida Condo Financing: Warrantable vs Non-Warrantable", type: "Blog", status: "idea", date: "", author: "Keith Meredith", note: "feeds condotel + non-warrantable pages" },

    // —— Blog: finished Feb drafts to rebuild to current quality bar (kept as drafts) ——
    { title: "2026 FHA Loan Limits: What Florida Buyers Need to Know", type: "Blog", status: "drafting", date: "", author: "Keith Meredith", note: "1,238w draft — rebuild to brm-article kit" },
    { title: "Why Mortgage Brokers Save You Money", type: "Blog", status: "drafting", date: "", author: "Keith Meredith", note: "1,439w draft — rebuild" },
    { title: "DSCR Loans Explained: Investor's Guide", type: "Blog", status: "drafting", date: "", author: "Keith Meredith", note: "1,538w draft — rebuild; supports DSCR page" },

    // —— Lender-niche Service Pages (224-lender pipeline, 2/wk, anti-mill: built from each lender's live guidelines) ——
    { title: "ITIN Home Loans (Florida)", type: "Service Page", status: "idea", date: "2026-07-06", note: "880 vol / LOW comp = top priority; BluePoint 85% LTV" },
    { title: "Foreign National Mortgage (Florida)", type: "Service Page", status: "idea", date: "2026-07-13", note: "590 / LOW; FL = #1 foreign-buyer state" },
    { title: "Asset Depletion / Asset-Based Mortgage", type: "Service Page", status: "idea", date: "2026-07-20", note: "590 / LOW; Villages retiree crossover" },
    { title: "Horse & Hobby Farm Financing (Ocala)", type: "Service Page", status: "idea", date: "2026-07-20", note: "Farmer Mac; un-copyable Ocala sleeper" },
    { title: "Non-Warrantable Condo Loans (Florida)", type: "Service Page", status: "idea", date: "2026-07-27", note: "390 / MED; interlink w/ condotel" },
    { title: "Mortgage After Foreclosure / Bankruptcy", type: "Service Page", status: "idea", date: "2026-08-03", note: "recent-credit-event; 1-day-out programs" },
    { title: "Fix & Flip Loans (Florida)", type: "Service Page", status: "idea", date: "2026-08-10", note: "spec ↔ flip ↔ DSCR triangle" },
    { title: "Investment-Property HELOC", type: "Service Page", status: "idea", date: "2026-08-17", note: "Quorum inv-property + bank-stmt HELOC" },

    // —— Location pages: future build queue ——
    { title: "Lady Lake / Wildwood (Villages overflow)", type: "Location Page", status: "idea", date: "" },
    { title: "Spring Hill / Brooksville (Hernando, mfg-heavy)", type: "Location Page", status: "idea", date: "" },
    { title: "Dunnellon · Crystal River / Inverness (Citrus)", type: "Location Page", status: "idea", date: "" },

    // —— SHIPPED / LIVE (launched 2026-06-12) ——
    { title: "Spec Construction Loans for Builders & Investors", type: "Service Page", status: "live", date: "2026-06-12", note: "0% pay-rate angle; weak SERP win" },
    { title: "Florida Physician Loans", type: "Service Page", status: "live", date: "2026-06-12" },
    { title: "Become a Mortgage Broker (LO recruiting)", type: "Page", status: "live", date: "2026-06-13", note: "was /work-with-us/; FAQ schema; n8n recruiting webhook" },
    { title: "Loan Programs hub — full directory rebuild (25 programs)", type: "Page", status: "live", date: "2026-06-13" },
    { title: "States We're Licensed In (interactive map)", type: "Page", status: "live", date: "2026-06-12" },
    { title: "Client Reviews (+ GMB review CTA)", type: "Page", status: "live", date: "2026-06-12" },
    { title: "City service-area pages: The Villages, Gainesville, Belleview", type: "Location Page", status: "live", date: "2026-06-12", note: "distinct angles + internal links + featured imgs" },
    { title: "Florida USDA Turn-Times (rebuilt, LLM-citation magnet)", type: "Blog", status: "live", date: "2026-06-12" }
  ]
});
