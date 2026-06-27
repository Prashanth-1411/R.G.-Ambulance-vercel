# R.G. Ambulance Service - Full Project Audit Report

## Environment
- **Laravel**: 12.x
- **PHP**: ^8.2 (composer.json)
- **Database**: PostgreSQL
- **Filament**: ^3.2
- **Storage**: Local (public) + Base64 blobs in DB
- **Deployment**: Vercel (serverless, ephemeral storage)

---

## CRITICAL ISSUES

### 🔴 CRITICAL 1: `FuneralServicesController` points to non-existent view
**File**: `app/Http/Controllers/Frontend/FuneralServicesController.php:19`
```php
return view('frontend.fleet', compact('settings', 'services'));
```
**Problem**: `resources/views/frontend/fleet.blade.php` does NOT exist. Only `fleet/index.blade.php` exists.
**Result**: Visiting any funeral services route will throw `ViewNotFound` HTTP 500.

---

### 🔴 CRITICAL 2: No route mapped for `FuneralServicesController`
**File**: `routes/web.php`
**Problem**: `FuneralServicesController::index()` exists but has no route in web.php. Dead controller.

---

### 🔴 CRITICAL 3: Cache never cleared when content changes via Filament Resources
**Files affected**:
- `app/Services/ThemeService.php` - caches `theme_settings` for 3600s
- `app/Services/SiteContentService.php` - caches `site_content` for 3600s
- Only `ThemeSettings` and `SiteSettings` filament pages call `ThemeService::clearCache()`
- All Filament Resources (SettingResource, PageResource, ServiceResource, etc.) DO NOT clear cache

**Result**: Admin changes → Website still shows stale data for up to 1 hour.

---

### 🔴 CRITICAL 4: Missing Filament Resources for 8+ Models
**Models without Filament Resources**:
| Model | DB Table | Purpose |
|-------|----------|---------|
| SisterConcern | sister_concerns | Sister companies |
| ServiceSpecification | service_specifications | Service specs |
| ServiceFeature | service_features | Service features |
| ServiceBrochure | service_brochures | Service brochures |
| GalleryImage | gallery_images | Gallery images (Album has resource, images don't) |
| Notification | notifications | Admin notifications |
| Configuration | configurations | Key-value config store |
| Capability | capabilities | Company capabilities |

---

### 🔴 CRITICAL 5: Upload HTTP 500 Risk in `HasImageBlobs` trait
**File**: `app/Models/Concerns/HasImageBlobs.php`
**Issues**:
1. `storeBlobs()` reads files and base64-encodes them on every `saving` event
2. Large images may exhaust PHP memory on encoding
3. On Vercel, uploaded files disappear after deployment, but blob columns remain
4. `getImageUrl()` returns `data:` URIs → slow page loads with large base64 strings
5. When `file_get_contents()` fails on external URLs, silent skip hides errors
6. Missing blob columns from failed migration would crash the trait

---

### 🔴 CRITICAL 6: `SeoMetum` doesn't use `HasImageBlobs` trait
**File**: `app/Models/SeoMetum.php`
**Problem**: `og_image` field stores URLs as plain strings. The Filament resource has FileUpload for og_image but the model has no blob support. Uploaded files will be stored but the URL stored in DB may not reference them correctly.

---

## MODERATE ISSUES

### 🟡 MODERATE 1: Missing CRUD methods in Admin Controllers
| Controller | Missing Methods |
|------------|----------------|
| ActivityLogController | create, store, edit, update, destroy |
| BookingController | create, store |
| ContactInquiryController | create, store, edit, update |
| NotificationController | create, store, show, edit, update, destroy |
| SeoMetumController | show |
| SettingController | create, store, show, edit, destroy |
| ThemeController | create, store, show, edit, destroy |

---

### 🟡 MODERATE 2: Missing Admin Views
| Module | Missing Views |
|--------|--------------|
| bookings | create |
| seo_meta | show |
| activity_logs | create, edit |
| contact_inquiries | create, edit |
| notifications | create, edit, show |
| settings | create, edit, show |

---

### 🟡 MODERATE 3: No admin fleet management views
**Problem**: `resources/views/admin/fleet/` directory does not exist. No CRUD views for fleet management in the old admin panel. (Filament FleetResource exists.)

---

### 🟡 MODERATE 4: Duplicate domain models
- `services` table has `service_type` column (`ambulance` or `funeral`)
- `funeral_services` table exists independently with nearly identical schema
- No relationship, FK, or documented distinction between them

---

### 🟡 MODERATE 5: Split booking systems
- `bookings` table for ambulance bookings
- `funeral_bookings` table for funeral bookings
- No unified view, no shared booking ID, inconsistent archival strategy

---

### 🟡 MODERATE 6: Seeders use `create()` not `firstOrCreate()`
| Seeder | Issue |
|--------|-------|
| SettingSeeder | Uses `create()` - duplicate on re-seed |
| HeroSlideSeeder | Uses `create()` - duplicate on re-seed |
| ServiceCategorySeeder | Uses `create()` - duplicate on re-seed |
| FleetSeeder | Uses `delete() + create()` - destructive re-seed |
| ServiceSeeder | Uses `delete() + create()` - destructive re-seed |
| NavigationItemSeeder | Uses `create()` - duplicate on re-seed |
| FaqSeeder | Uses `create()` - duplicate on re-seed |
| TestimonialSeeder | Uses `create()` - duplicate on re-seed |
| BlogCategorySeeder | Uses `create()` - duplicate on re-seed |
| BlogPostSeeder | Uses `create()` - duplicate on re-seed |
| TeamMemberSeeder | Uses `create()` - duplicate on re-seed |
| CertificateSeeder | Uses `create()` - duplicate on re-seed |
| CompanyTimelineSeeder | Uses `create()` - duplicate on re-seed |

---

### 🟡 MODERATE 7: No authorization on any controller
No policies, no `$this->authorize()`, no gates used anywhere.

---

### 🟡 MODERATE 8: `FleetController.show()` - slug collision risk
**File**: `app/Http/Controllers/Frontend/FleetController.php:22`
**Problem**: Tries `FleetCategory::where('slug', $slug)->first()` first, then `Fleet::where('slug', $slug)`. If a category and fleet share the same slug, the fleet is never reachable.

---

### 🟡 MODERATE 9: No frontend routes for blog, gallery, funeral bookings, equipment rentals
Missing frontend routes that would be expected from a complete website.

---

## MINOR ISSUES

### 🔵 MINOR 1: `FILESYSTEM_DISK=public` not in .env
Current `.env` has no `FILESYSTEM_DISK` setting. Defaults to `local`.

### 🔵 MINOR 2: `storage:link` not in deployment script
`vercel-build` script in composer.json does not run `php artisan storage:link`.

### 🔵 MINOR 3: URL hardcoded in views
Multiple views reference hardcoded Unsplash URLs as fallback images.

### 🔵 MINOR 4: `fleets.category` column is redundant
After adding `fleet_category_id` FK to `fleet_categories`, the original string `category` column is unused/conflicting.

### 🔵 MINOR 5: `Setting::find(1)` in controllers
Two controllers use `Setting::find(1)` directly instead of the centrally provided `$site` variable.

### 🔵 MINOR 6: Missing `image` column on `equipment_rentals`
The migration adds `image` but original schema didn't have it. Works but not clean.

---

## SUMMARY

| Severity | Count | Action Required |
|----------|-------|-----------------|
| 🔴 Critical | 6 | Immediate fix |
| 🟡 Moderate | 9 | Fix during CRUD completion phase |
| 🔵 Minor | 6 | Fix during hardening phase |
