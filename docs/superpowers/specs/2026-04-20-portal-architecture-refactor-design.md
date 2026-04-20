# Portal Karya Seniman Architecture Refactor Design

## Summary

This design defines a focused architectural refactor for the Laravel monolith in this repository. The goal is to improve maintainability without a rewrite. The work centers on the karya domain because it contains the application's core workflow: artist submission, admin review, publication status, authorization, and file handling.

The refactor keeps the current stack and route structure. It introduces clearer boundaries inside the existing app: controllers handle HTTP, form requests handle validation, actions or services handle business operations, models and policies define domain rules, and reusable query logic moves out of controllers and views.

## Goals

- Centralize karya status rules and transitions.
- Reduce controller responsibility.
- Remove duplicated validation logic.
- Standardize authorization behavior.
- Move reusable query logic out of controllers and Blade views.
- Make file upload and replacement behavior consistent.
- Add enough automated tests to support safe refactoring.

## Non-Goals

- No rewrite to SPA, Livewire, or Inertia.
- No repository-pattern overhaul across the whole app.
- No redesign of the database schema beyond minimal support changes.
- No broad visual redesign.
- No modularization into packages.

## Current Problems

### 1. Status workflow is spread across the codebase

Karya status values and transitions are duplicated across the migration, model, policy, and controllers. This creates multiple sources of truth and makes change risky.

Examples:
- `database/migrations/2026_04_08_114312_create_karya_seni_table.php:27`
- `app/Models/KaryaSeni.php:76-79`
- `app/Models/KaryaSeni.php:115-145`
- `app/Policies/KaryaSeniPolicy.php:25-43`
- `app/Http/Controllers/Admin/KaryaSeniController.php:64-95`

### 2. Controllers hold too much business logic

Several controllers mix validation, file storage, domain rules, persistence, and redirects in single methods.

Examples:
- `app/Http/Controllers/Seniman/KaryaSeniController.php:29-79`
- `app/Http/Controllers/Seniman/KaryaSeniController.php:92-143`
- `app/Http/Controllers/Admin/KaryaSeniController.php:64-95`
- `app/Http/Controllers/Admin/KategoriController.php:23-48`

### 3. Validation is duplicated

Store and update rules are repeated across multiple controllers, which increases drift risk.

Examples:
- `app/Http/Controllers/Admin/KategoriController.php:25-33`
- `app/Http/Controllers/Admin/KategoriController.php:62-70`
- `app/Http/Controllers/Admin/SliderController.php:24-32`
- `app/Http/Controllers/Admin/SliderController.php:49-57`

### 4. Authorization is fragmented

Access checks are split across role middleware, gates, policies, and controller assumptions.

Examples:
- `app/Http/Middleware/CheckRole.php:12-63`
- `app/Providers/AppServiceProvider.php:23-35`
- `app/Policies/KaryaSeniPolicy.php:8-53`

### 5. Query logic leaks into controllers and views

Filtering and selection logic is defined in controllers and one category query is executed directly from the public layout.

Examples:
- `app/Http/Controllers/Public/SenimanController.php:12-35`
- `app/Http/Controllers/Public/HomeController.php:73-96`
- `resources/views/layouts/public.blade.php:77-79`

### 6. File lifecycle is inconsistent

Uploaded files are stored, but replacement and deletion paths are not handled uniformly.

Examples:
- `app/Http/Controllers/Seniman/KaryaSeniController.php:45-77`
- `app/Http/Controllers/Seniman/KaryaSeniController.php:120-140`
- `app/Http/Controllers/Admin/SliderController.php:34-37`

### 7. Test coverage is too thin for safe refactoring

The test suite only contains default example tests.

Examples:
- `tests/Feature/ExampleTest.php:13-18`
- `tests/Unit/ExampleTest.php:13-15`

## Recommended Approach

Use a targeted domain-first refactor inside the existing Laravel monolith.

Why this approach:
- It fixes the highest-value problems without a rewrite.
- It keeps the UI, routes, and deployment model stable.
- It allows work to proceed in small, reviewable steps.
- It gives the karya workflow a clean backbone first, then applies the same pattern to smaller admin features.

## Proposed Architecture

The target request flow is:

`Route -> Controller -> FormRequest -> Action/Service -> Model/Policy/Storage/Query -> View or Redirect`

### Controller responsibilities

Controllers should:
- Receive the request.
- Delegate validation to a form request.
- Call a single action or service.
- Return a view or redirect.

Controllers should not:
- Build long validation arrays.
- Encode status-transition rules.
- Manage repeated storage cleanup logic.
- Construct complex query rules inline when they are reusable.

### FormRequest responsibilities

Form requests will own validation and authorization-at-request-entry where appropriate.

Initial candidates:
- `StoreKaryaRequest`
- `UpdateKaryaRequest`
- `SubmitReviewKaryaRequest`
- `StoreKategoriRequest`
- `UpdateKategoriRequest`
- `StoreSliderRequest`
- `UpdateSliderRequest`
- `StoreKataSambutanRequest`
- `UpdateKataSambutanRequest`

### Action and service responsibilities

Actions or services will own business operations that are currently embedded in controllers.

Initial candidates:
- `CreateKaryaDraft`
- `UpdateKaryaDraft`
- `SubmitKaryaForReview`
- `ReviewKaryaSubmission`
- `ReplaceStoredFile`
- `DeleteKaryaAssets`
- `BuildAdminDashboardStats`
- `BuildSenimanDashboardStats`

These classes should stay focused. Each should do one job and expose a clear entry point.

## Karya Domain Design

### Central status definition

The karya domain needs one canonical status definition. The simplest acceptable design is a shared constant class or PHP enum. It must define:
- allowed statuses
- labels
- badge color mapping
- editable states
- submittable states
- admin review outcomes

This replaces scattered string lists and repeated match expressions.

### Transition rules

Status transitions must be enforced in one place.

Required transitions:
- `draft -> diajukan`
- `perlu_revisi -> diajukan`
- `diajukan -> perlu_revisi`
- `diajukan -> ditolak`
- `diajukan -> dipublikasikan` through approval flow

For the first refactor cycle, the application should preserve current business behavior: an approved review publishes the karya immediately. In other words, `disetujui` remains a review outcome, not a long-lived persisted `status_karya` stage for this cycle.

The admin review action should accept the intended review outcome and compute the resulting karya status. Controllers should not decide how approval maps to publication; the domain operation should.

### Ownership and edit rules

The current ownership rules in `KaryaSeniPolicy` should remain policy-based, but the set of editable states must come from the centralized status definition. That keeps policy decisions and domain rules aligned.

## Authorization Design

Authorization should use two levels:

### Level 1: Area access

Keep role middleware only for broad area separation:
- admin area
- seniman area

The middleware should become minimal. It should stop producing noisy per-request debug logging and should avoid role-specific business messaging when a simple deny or redirect is sufficient.

### Level 2: Resource permissions

Use policies for resource-level decisions such as:
- who can edit a karya
- who can delete a karya
- who can review a karya
- who can view unpublished data

Gate definitions that duplicate role checks should be removed unless they are still needed by a view-level authorization API. If they remain, they should map cleanly to the same policy model and not create parallel logic.

## Query and Read Model Design

### Reusable query logic

Move repeated filters into scopes or small query builders.

Initial extraction targets:
- public artist search and filtering
- public karya search
- dashboard status counts
- public category list for layout navigation

### Public layout category data

The category query currently executed in `resources/views/layouts/public.blade.php:77-79` should move out of the Blade view. Use a view composer or a controller-shared data mechanism so the layout receives prepared data.

### Query correctness

The public artist search logic must group predicates correctly so `orWhere` conditions do not bypass active-user constraints. This is both a correctness issue and an architectural clarity issue.

## File Handling Design

Create a consistent file lifecycle pattern for uploads.

Required behavior:
- create stores new file paths
- update replaces files and deletes obsolete files
- delete removes owned files when the record is deleted
- multi-file karya media cleanup is handled deliberately

This logic should not be reimplemented in each controller. File storage coordination should live in dedicated actions or services.

## Dashboard Design

Dashboard statistics are currently assembled through many repeated count queries. Introduce small builder services for admin and seniman dashboards.

These services should:
- gather counts in one place
- define the dashboard contract clearly
- make later optimization easier

Caching is optional and should only be added if measurement shows the need.

## Testing Design

Add feature tests before or alongside the refactor in the highest-risk areas.

Priority coverage:
- admin and seniman route protection
- karya edit permissions by owner and status
- karya submission transition rules
- admin review transition rules
- public search correctness
- file replacement and deletion with fake storage

The goal is not exhaustive coverage. The goal is a safety net for the architectural seams being changed.

## Rollout Plan

The refactor should be executed in this order:

1. Add feature tests for karya workflow and authorization.
2. Centralize karya statuses and transition rules.
3. Refactor seniman and admin karya controllers to use form requests and actions.
4. Clean up authorization boundaries.
5. Move reusable query logic out of controllers and remove the Blade query.
6. Refactor kategori, slider, and kata sambutan CRUD to the same request-action pattern.
7. Centralize dashboard statistics.
8. Finish file lifecycle cleanup and regression testing.

## Trade-Offs

### Benefits
- Lower change risk in the karya domain.
- Better testability.
- Less duplication.
- Clearer responsibility boundaries.
- Easier onboarding for future maintenance work.

### Costs
- More classes than the current controller-heavy design.
- Short-term churn in the most active features.
- Some temporary inconsistency until all targeted domains follow the same pattern.

These trade-offs are acceptable because the current design already carries hidden complexity; this refactor makes that complexity explicit and manageable.

## Acceptance Criteria

This design is successful when:
- karya status rules live in one canonical definition
- admin review and artist submission no longer encode workflow rules in controllers
- targeted controllers delegate business operations to form requests and actions
- policy decisions use the same status rules as the domain
- the public layout does not execute category queries directly
- upload replacement and deletion are consistent in the refactored areas
- high-risk karya and authorization flows are covered by feature tests

## Open Questions Resolved

- **Rewrite vs refactor:** Refactor in place.
- **Scope center:** Start with the karya domain, then apply the same pattern to supporting admin CRUD.
- **Repository pattern:** Not needed at this stage.
- **Frontend change:** None required for this refactor.

## Out of Scope for the First Refactor Cycle

The following items may be revisited later, but are not part of this design:
- broad UI redesign
- replacing Blade with a client-rendered frontend
- advanced caching strategy
- search engine integration
- deeper analytics or reporting features
