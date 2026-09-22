---
id: EP-20260922_175321_1065
type: episode
title: Resolved Route Function Undefined in Vue Runtime
summary: Created lightweight route helper in lib/route.ts and attached to window and Vue app instance to provide global route resolution.
status: active
tags: [vue, routes, wayfinder, inertia]
created_at: 2026-09-22
updated_at: 2026-09-22
---
> **CRITICAL RULE FOR ALL NOTES & CARDS:**
> All contents must be concise and straight to the point. Include only high-signal, necessary information. No fluff, no filler.

# Resolved Route Function Undefined in Vue Runtime

In this starter kit Wayfinder is used instead of Ziggy. Created resources/js/lib/route.ts mapping application routes and registered it in resources/js/app.ts as app.config.globalProperties.route and window.route. Rebuilt assets.
