---
id: EP-20260922_164546_26cd
type: episode
title: Resolved ViteManifestNotFoundException
summary: Generated missing public/build/manifest.json by compiling assets with npm run build.
status: active
tags: [vite, build, assets, laravel]
created_at: 2026-09-22
updated_at: 2026-09-22
---

> **CRITICAL RULE FOR ALL NOTES & CARDS:**
> All contents must be concise and straight to the point. Include only high-signal, necessary information. No fluff, no filler.

# Resolved ViteManifestNotFoundException

When serving via Herd without npm run dev running, Laravel requires public/build/manifest.json. Running npm run build generated all production bundles and resolved the ViteManifestNotFoundException.
