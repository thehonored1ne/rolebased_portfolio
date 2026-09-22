---
id: EP-20260922_204139_4a0c
type: episode
title: Fix Admin Sidebar Inactive Item Contrast
summary: Add explicit text-black and override sidebar theme variables so nav items stay visible in dark mode
status: active
tags: [ui, sidebar, neobrutalism, tailwind]
created_at: 2026-09-22
updated_at: 2026-09-22
---
> **CRITICAL RULE FOR ALL NOTES & CARDS:**
> All contents must be concise and straight to the point. Include only high-signal, necessary information. No fluff, no filler.

# Fix Admin Sidebar Inactive Item Contrast

Sidebar inherited text-sidebar-foreground (near white in dark mode) via text-inherit in NavMain.vue, causing inactive links to blend into the light background until hovered. Fixed by overriding sidebar CSS variables to monochrome in AppSidebar.vue and explicitly binding !text-black when inactive and !text-white when active on NavMain.vue and NavUser.vue.
