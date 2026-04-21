# Portal Karya Seniman Architecture Refactor Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Refactor the portal app so the karya workflow, authorization, public query layer, upload lifecycle, and core admin CRUD are easier to change and safer to test.

**Architecture:** Keep the Laravel monolith and route structure, but move validation into form requests, business operations into focused actions/services, and reusable rules into enums, scopes, and view composers. Execute the work domain-first: fix test data setup, centralize karya status rules, extract karya actions, then apply the same pattern to public read logic, dashboards, and supporting admin CRUD.

**Tech Stack:** PHP 8.2, Laravel 12, Blade, Eloquent, PHPUnit, SQLite in-memory testing, Laravel Storage fake

---

## File Structure

### Test and fixture support
- Modify: `database/factories/UserFactory.php` — align factory fields with the real `users` table and add role/status states.
- Create: `database/factories/KategoriFactory.php` — generate active and inactive kategori records.
- Create: `database/factories/ProfilSenimanFactory.php` — generate public artist profiles tied to a user.
- Create: `database/factories/KaryaSeniFactory.php` — generate karya records in each workflow state.
- Modify: `app/Models/Kategori.php` — add `HasFactory` and keep active scope.
- Modify: `app/Models/ProfilSeniman.php` — add `HasFactory` and later add public/search scopes.
- Modify: `app/Models/KaryaSeni.php` — add `HasFactory`, cast `status_karya`, and host shared query helpers.

### Karya workflow
- Create: `app/Enums/KaryaStatus.php` — canonical karya statuses, labels, badge colors, editable states, submittable states, and review outcomes.
- Create: `app/Http/Requests/Admin/SubmitReviewKaryaRequest.php` — validate and authorize admin review submissions.
- Create: `app/Http/Requests/Seniman/StoreKaryaRequest.php` — validate artist karya creation.
- Create: `app/Http/Requests/Seniman/UpdateKaryaRequest.php` — validate artist karya updates.
- Create: `app/Actions/Karya/SubmitKaryaForReview.php` — move draft or revision karya into the submitted state.
- Create: `app/Actions/Karya/ReviewKaryaSubmission.php` — turn review outcomes into persisted karya state and create review history.
- Create: `app/Actions/Karya/StoreUploadedKaryaMedia.php` — append uploaded media records to a karya.
- Create: `app/Actions/Karya/CreateKaryaDraft.php` — create a draft karya and store thumbnail/media uploads.
- Create: `app/Actions/Karya/UpdateKaryaDraft.php` — update draft metadata and replace thumbnail when needed.
- Create: `app/Actions/Karya/DeleteKaryaAssets.php` — delete thumbnail files, media files, and media rows before soft delete.
- Create: `app/Actions/Files/ReplaceStoredFile.php` — replace one stored file and remove the obsolete path.
- Create: `app/Actions/Files/DeleteStoredFiles.php` — delete one or more stored files safely.
- Modify: `app/Policies/KaryaSeniPolicy.php` — add `review` and use centralized editable-state logic.
- Modify: `app/Http/Controllers/Seniman/KaryaSeniController.php` — delegate to form requests and actions.
- Modify: `app/Http/Controllers/Admin/KaryaSeniController.php` — delegate review logic to a request and action.
- Modify: `resources/views/admin/karya/review.blade.php` — align the review form route, HTTP verb, status values, and field names with the new request contract.

### Public query/read model
- Create: `app/View/Composers/PublicLayoutComposer.php` — inject active categories into the public layout.
- Modify: `app/Providers/AppServiceProvider.php` — register the policy, keep AdminLTE gates, and register the public layout composer.
- Modify: `app/Http/Controllers/Public/SenimanController.php` — use profile scopes instead of inline predicate trees.
- Modify: `app/Http/Controllers/Public/KaryaController.php` — use reusable karya search logic.
- Modify: `app/Http/Controllers/Public/HomeController.php` — use profile search scope for search results.
- Modify: `resources/views/layouts/public.blade.php` — remove the inline kategori query and consume injected data.

### Dashboard and auth boundary
- Create: `app/Services/Dashboard/BuildAdminDashboardStats.php` — centralize admin dashboard count queries.
- Create: `app/Services/Dashboard/BuildSenimanDashboardStats.php` — centralize seniman dashboard count queries.
- Modify: `app/Http/Controllers/Admin/DashboardController.php` — consume stats service.
- Modify: `app/Http/Controllers/Seniman/DashboardController.php` — consume stats service.
- Modify: `app/Http/Controllers/Admin/SenimanController.php` — switch artist detail statistics to the centralized status source.
- Modify: `app/Http/Middleware/CheckRole.php` — keep area access checks minimal and remove debug logging.

### Supporting admin CRUD
- Create: `app/Http/Requests/Admin/StoreKategoriRequest.php`
- Create: `app/Http/Requests/Admin/UpdateKategoriRequest.php`
- Create: `app/Http/Requests/Admin/StoreSliderRequest.php`
- Create: `app/Http/Requests/Admin/UpdateSliderRequest.php`
- Create: `app/Http/Requests/Admin/StoreKataSambutanRequest.php`
- Create: `app/Http/Requests/Admin/UpdateKataSambutanRequest.php`
- Create: `app/Actions/Admin/SaveKategori.php`
- Create: `app/Actions/Admin/SaveSlider.php`
- Create: `app/Actions/Admin/SaveKataSambutan.php`
- Modify: `app/Http/Controllers/Admin/KategoriController.php`
- Modify: `app/Http/Controllers/Admin/SliderController.php`
- Modify: `app/Http/Controllers/Admin/KataSambutanController.php`

### Tests
- Create: `tests/Feature/Factories/FactorySmokeTest.php`
- Create: `tests/Feature/Auth/RoleAreaAccessTest.php`
- Create: `tests/Feature/Karya/KaryaPolicyTest.php`
- Create: `tests/Unit/Karya/KaryaStatusTest.php`
- Create: `tests/Feature/Karya/KaryaWorkflowActionsTest.php`
- Create: `tests/Feature/Karya/KaryaFileLifecycleTest.php`
- Create: `tests/Feature/Public/PublicArtistSearchTest.php`
- Create: `tests/Feature/Public/PublicLayoutComposerTest.php`
- Create: `tests/Feature/Dashboard/DashboardStatsServiceTest.php`
- Create: `tests/Feature/Admin/SupportingCrudRefactorTest.php`

### Task 1: Repair test data foundations

**Files:**
- Create: `tests/Feature/Factories/FactorySmokeTest.php`
- Modify: `database/factories/UserFactory.php`
- Create: `database/factories/KategoriFactory.php`
- Create: `database/factories/ProfilSenimanFactory.php`
- Create: `database/factories/KaryaSeniFactory.php`
- Modify: `app/Models/Kategori.php`
- Modify: `app/Models/ProfilSeniman.php`
- Modify: `app/Models/KaryaSeni.php`

- [ ] **Step 1: Write the failing factory smoke test**

```php
<?php

namespace Tests\Feature\Factories;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactorySmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_factory_matches_the_users_table_schema(): void
    {
        $user = User::factory()->create(['peran' => 'seniman']);

        $this->assertSame('seniman', $user->peran);
        $this->assertNotSame('', $user->nama);
    }
}
```

- [ ] **Step 2: Run the smoke test and confirm the current factory is broken**

Run:

```bash
rtk php artisan test tests/Feature/Factories/FactorySmokeTest.php
```

Expected: FAIL with a database error because `database/factories/UserFactory.php` still writes the old `name` field instead of `nama`.

- [ ] **Step 3: Update `database/factories/UserFactory.php` to match the real schema**

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nomor_hp' => fake()->numerify('0812########'),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'peran' => 'seniman',
            'status_akun' => 'aktif',
            'terakhir_login_pada' => null,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['peran' => 'admin']);
    }

    public function seniman(): static
    {
        return $this->state(fn () => ['peran' => 'seniman']);
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => ['status_akun' => 'nonaktif']);
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }
}
```

- [ ] **Step 4: Add `HasFactory` to the domain models the tests will use**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'ikon',
        'gambar',
        'urutan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function karyaSeni(): HasMany
    {
        return $this->hasMany(KaryaSeni::class);
    }

    public function karyaSeniPublik(): HasMany
    {
        return $this->hasMany(KaryaSeni::class)->where('status_karya', 'dipublikasikan');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
            }
        });

        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama_kategori') && empty($kategori->slug)) {
                $kategori->slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
            }
        });
    }
}
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilSeniman extends Model
{
    use HasFactory;

    protected $table = 'profil_seniman';

    protected $fillable = [
        'user_id',
        'nama_panggung',
        'foto_profil',
        'foto_sampul',
        'biografi',
        'bidang_seni_utama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kabupaten_kota',
        'provinsi',
        'instagram',
        'facebook',
        'youtube',
        'situs_web',
        'prestasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->user?->nama ?? '-';
    }

    public function getNamaTampilanAttribute(): string
    {
        return $this->nama_panggung ?? $this->getNamaLengkapAttribute();
    }

    public function getFotoProfilUrlAttribute(): string
    {
        return $this->foto_profil ? asset('storage/' . $this->foto_profil) : asset('images/no-avatar.jpg');
    }

    public function getFotoSampulUrlAttribute(): ?string
    {
        return $this->foto_sampul ? asset('storage/' . $this->foto_sampul) : null;
    }
}
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KaryaSeni extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karya_seni';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul_karya',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'tahun_karya',
        'media_karya',
        'dimensi',
        'lokasi_asal',
        'thumbnail',
        'status_karya',
        'catatan_admin_terbaru',
        'diajukan_pada',
        'disetujui_pada',
        'dipublikasikan_pada',
        'jumlah_dilihat',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'jumlah_dilihat' => 'integer',
        'diajukan_pada' => 'datetime',
        'disetujui_pada' => 'datetime',
        'dipublikasikan_pada' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function mediaKarya(): HasMany
    {
        return $this->hasMany(MediaKarya::class);
    }

    public function reviewKarya(): HasMany
    {
        return $this->hasMany(ReviewKarya::class);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getNamaSenimanAttribute(): string
    {
        return $this->user?->profilSeniman?->nama_tampilan ?? $this->user?->nama ?? 'Unknown';
    }

    public function scopePublik($query)
    {
        return $query->where('status_karya', 'dipublikasikan')->where('status_aktif', true);
    }

    public function scopeMilikSeniman($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_karya', $status);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karya) {
            if (empty($karya->slug)) {
                $karya->slug = Str::slug($karya->judul_karya) . '-' . uniqid();
            }
        });
    }

    public function incrementViewCount(): void
    {
        $this->increment('jumlah_dilihat');
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $this->user_id === $user->id && in_array($this->status_karya, ['draft', 'perlu_revisi']);
    }

    public function canBeSubmitted(): bool
    {
        return in_array($this->status_karya, ['draft', 'perlu_revisi']);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status_karya) {
            'draft' => 'secondary',
            'diajukan' => 'info',
            'perlu_revisi' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'dipublikasikan' => 'primary',
            'diarsipkan' => 'dark',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_karya) {
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'perlu_revisi' => 'Perlu Revisi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipublikasikan' => 'Dipublikasikan',
            'diarsipkan' => 'Diarsipkan',
            default => $this->status_karya,
        };
    }
}
```

- [ ] **Step 5: Create the missing kategori, profil, and karya factories**

```php
<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'nama_kategori' => Str::title($name),
            'slug' => Str::slug($name),
            'deskripsi' => fake()->sentence(),
            'ikon' => 'bi bi-palette',
            'gambar' => null,
            'urutan' => fake()->numberBetween(1, 20),
            'status_aktif' => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => ['status_aktif' => false]);
    }
}
```

```php
<?php

namespace Database\Factories;

use App\Models\ProfilSeniman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilSenimanFactory extends Factory
{
    protected $model = ProfilSeniman::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->seniman(),
            'nama_panggung' => fake()->name(),
            'foto_profil' => null,
            'foto_sampul' => null,
            'biografi' => fake()->paragraph(),
            'bidang_seni_utama' => fake()->randomElement(['Lukis', 'Tari', 'Musik', 'Patung']),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan', 'lainnya']),
            'alamat' => fake()->address(),
            'kabupaten_kota' => fake()->city(),
            'provinsi' => 'Nusa Tenggara Barat',
            'instagram' => fake()->userName(),
            'facebook' => fake()->userName(),
            'youtube' => fake()->userName(),
            'situs_web' => fake()->url(),
            'prestasi' => fake()->sentence(),
        ];
    }
}
```

```php
<?php

namespace Database\Factories;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KaryaSeniFactory extends Factory
{
    protected $model = KaryaSeni::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'user_id' => User::factory()->seniman(),
            'kategori_id' => Kategori::factory(),
            'judul_karya' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'deskripsi_singkat' => fake()->sentence(),
            'deskripsi_lengkap' => fake()->paragraph(),
            'tahun_karya' => '2024',
            'media_karya' => 'Akrilik',
            'dimensi' => '100 x 100 cm',
            'lokasi_asal' => 'Sumbawa Besar',
            'thumbnail' => 'karya/thumbnails/default.webp',
            'status_karya' => 'draft',
            'catatan_admin_terbaru' => null,
            'diajukan_pada' => null,
            'disetujui_pada' => null,
            'dipublikasikan_pada' => null,
            'jumlah_dilihat' => 0,
            'status_aktif' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status_karya' => 'draft']);
    }

    public function diajukan(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'diajukan',
            'diajukan_pada' => now(),
        ]);
    }

    public function perluRevisi(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'perlu_revisi',
            'diajukan_pada' => now()->subDay(),
        ]);
    }

    public function dipublikasikan(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'dipublikasikan',
            'diajukan_pada' => now()->subDays(2),
            'disetujui_pada' => now()->subDay(),
            'dipublikasikan_pada' => now()->subDay(),
        ]);
    }
}
```

- [ ] **Step 6: Run the smoke test again**

Run:

```bash
rtk php artisan test tests/Feature/Factories/FactorySmokeTest.php
```

Expected: PASS.

- [ ] **Step 7: Commit the fixture foundation**

```bash
rtk git add tests/Feature/Factories/FactorySmokeTest.php database/factories/UserFactory.php database/factories/KategoriFactory.php database/factories/ProfilSenimanFactory.php database/factories/KaryaSeniFactory.php app/Models/Kategori.php app/Models/ProfilSeniman.php app/Models/KaryaSeni.php && rtk git commit -m "test: add schema-aligned domain factories"
```

### Task 2: Lock down area access and review policy

**Files:**
- Create: `tests/Feature/Auth/RoleAreaAccessTest.php`
- Create: `tests/Feature/Karya/KaryaPolicyTest.php`
- Modify: `app/Policies/KaryaSeniPolicy.php`

- [ ] **Step 1: Write the baseline area-access and policy tests**

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAreaAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_protected_areas(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/dashboard-seniman')->assertRedirect(route('login'));
    }

    public function test_seniman_is_redirected_away_from_admin_area(): void
    {
        $seniman = User::factory()->seniman()->create();

        $this->actingAs($seniman)
            ->get('/admin/dashboard')
            ->assertRedirect(route('seniman.dashboard'));
    }

    public function test_admin_is_redirected_away_from_seniman_area(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard-seniman')
            ->assertRedirect(route('admin.dashboard'));
    }
}
```

```php
<?php

namespace Tests\Feature\Karya;

use App\Models\KaryaSeni;
use App\Models\User;
use App\Policies\KaryaSeniPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryaPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_review_only_submitted_karya(): void
    {
        $policy = new KaryaSeniPolicy();
        $admin = User::factory()->admin()->create();
        $submitted = KaryaSeni::factory()->diajukan()->create();
        $draft = KaryaSeni::factory()->draft()->create();

        $this->assertTrue($policy->review($admin, $submitted));
        $this->assertFalse($policy->review($admin, $draft));
    }

    public function test_owner_can_only_edit_draft_like_states(): void
    {
        $policy = new KaryaSeniPolicy();
        $owner = User::factory()->seniman()->create();

        $draft = KaryaSeni::factory()->for($owner)->draft()->create();
        $revision = KaryaSeni::factory()->for($owner)->perluRevisi()->create();
        $published = KaryaSeni::factory()->for($owner)->dipublikasikan()->create();

        $this->assertTrue($policy->update($owner, $draft));
        $this->assertTrue($policy->update($owner, $revision));
        $this->assertFalse($policy->update($owner, $published));
    }
}
```

- [ ] **Step 2: Run the tests and confirm `review()` is missing**

Run:

```bash
rtk php artisan test tests/Feature/Auth/RoleAreaAccessTest.php tests/Feature/Karya/KaryaPolicyTest.php
```

Expected: FAIL with an error because `App\Policies\KaryaSeniPolicy::review()` does not exist yet.

- [ ] **Step 3: Add `review()` to `app/Policies/KaryaSeniPolicy.php` and keep resource permissions explicit**

```php
<?php

namespace App\Policies;

use App\Models\KaryaSeni;
use App\Models\User;

class KaryaSeniPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin() || $karyaSeni->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isSeniman();
    }

    public function update(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && in_array($karyaSeni->status_karya, ['draft', 'perlu_revisi'], true);
    }

    public function delete(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && $karyaSeni->status_karya === 'draft';
    }

    public function review(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin() && $karyaSeni->status_karya === 'diajukan';
    }

    public function restore(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }
}
```

- [ ] **Step 4: Run the access and policy tests again**

Run:

```bash
rtk php artisan test tests/Feature/Auth/RoleAreaAccessTest.php tests/Feature/Karya/KaryaPolicyTest.php
```

Expected: PASS.

- [ ] **Step 5: Commit the access-control baseline**

```bash
rtk git add tests/Feature/Auth/RoleAreaAccessTest.php tests/Feature/Karya/KaryaPolicyTest.php app/Policies/KaryaSeniPolicy.php && rtk git commit -m "test: lock role access and karya review policy"
```

### Task 3: Centralize karya status rules

**Files:**
- Create: `app/Enums/KaryaStatus.php`
- Create: `tests/Unit/Karya/KaryaStatusTest.php`
- Modify: `app/Models/KaryaSeni.php`
- Modify: `app/Policies/KaryaSeniPolicy.php`

- [ ] **Step 1: Write the failing unit test for canonical status behavior**

```php
<?php

namespace Tests\Unit\Karya;

use App\Enums\KaryaStatus;
use PHPUnit\Framework\TestCase;

class KaryaStatusTest extends TestCase
{
    public function test_editable_and_submittable_states_are_centralized(): void
    {
        $this->assertTrue(KaryaStatus::Draft->canBeEditedBySeniman());
        $this->assertTrue(KaryaStatus::PerluRevisi->canBeSubmittedBySeniman());
        $this->assertFalse(KaryaStatus::Dipublikasikan->canBeEditedBySeniman());
        $this->assertSame(['perlu_revisi', 'disetujui', 'ditolak'], KaryaStatus::reviewOutcomes());
        $this->assertSame('primary', KaryaStatus::Dipublikasikan->badgeColor());
    }
}
```

- [ ] **Step 2: Run the unit test and confirm the enum does not exist yet**

Run:

```bash
rtk php artisan test tests/Unit/Karya/KaryaStatusTest.php
```

Expected: FAIL with `Class "App\Enums\KaryaStatus" not found`.

- [ ] **Step 3: Create `app/Enums/KaryaStatus.php` as the single source of truth**

```php
<?php

namespace App\Enums;

enum KaryaStatus: string
{
    case Draft = 'draft';
    case Diajukan = 'diajukan';
    case PerluRevisi = 'perlu_revisi';
    case Ditolak = 'ditolak';
    case Dipublikasikan = 'dipublikasikan';
    case Diarsipkan = 'diarsipkan';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Diajukan => 'Diajukan',
            self::PerluRevisi => 'Perlu Revisi',
            self::Ditolak => 'Ditolak',
            self::Dipublikasikan => 'Dipublikasikan',
            self::Diarsipkan => 'Diarsipkan',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Draft => 'secondary',
            self::Diajukan => 'info',
            self::PerluRevisi => 'warning',
            self::Ditolak => 'danger',
            self::Dipublikasikan => 'primary',
            self::Diarsipkan => 'dark',
        };
    }

    public function canBeEditedBySeniman(): bool
    {
        return in_array($this, self::editableBySeniman(), true);
    }

    public function canBeSubmittedBySeniman(): bool
    {
        return in_array($this, self::submittableBySeniman(), true);
    }

    public static function editableBySeniman(): array
    {
        return [self::Draft, self::PerluRevisi];
    }

    public static function submittableBySeniman(): array
    {
        return [self::Draft, self::PerluRevisi];
    }

    public static function reviewOutcomes(): array
    {
        return ['perlu_revisi', 'disetujui', 'ditolak'];
    }
}
```

- [ ] **Step 4: Update the model and policy to use `KaryaStatus` instead of scattered strings**

Replace the relevant parts of `app/Models/KaryaSeni.php` with:

```php
use App\Enums\KaryaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KaryaSeni extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'status_karya' => KaryaStatus::class,
        'status_aktif' => 'boolean',
        'jumlah_dilihat' => 'integer',
        'diajukan_pada' => 'datetime',
        'disetujui_pada' => 'datetime',
        'dipublikasikan_pada' => 'datetime',
    ];

    public function scopePublik($query)
    {
        return $query->where('status_karya', KaryaStatus::Dipublikasikan->value)
            ->where('status_aktif', true);
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $this->user_id === $user->id
            && $this->status_karya->canBeEditedBySeniman();
    }

    public function canBeSubmitted(): bool
    {
        return $this->status_karya->canBeSubmittedBySeniman();
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return $this->status_karya->badgeColor();
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status_karya->label();
    }
}
```

Replace the relevant parts of `app/Policies/KaryaSeniPolicy.php` with:

```php
<?php

namespace App\Policies;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;

class KaryaSeniPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin() || $karyaSeni->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isSeniman();
    }

    public function update(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && $karyaSeni->status_karya->canBeEditedBySeniman();
    }

    public function delete(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && $karyaSeni->status_karya === KaryaStatus::Draft;
    }

    public function review(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin() && $karyaSeni->status_karya === KaryaStatus::Diajukan;
    }

    public function restore(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }
}
```

- [ ] **Step 5: Run the status and policy tests**

Run:

```bash
rtk php artisan test tests/Unit/Karya/KaryaStatusTest.php tests/Feature/Karya/KaryaPolicyTest.php
```

Expected: PASS.

- [ ] **Step 6: Commit the centralized status rules**

```bash
rtk git add app/Enums/KaryaStatus.php tests/Unit/Karya/KaryaStatusTest.php app/Models/KaryaSeni.php app/Policies/KaryaSeniPolicy.php && rtk git commit -m "refactor: centralize karya status rules"
```

### Task 4: Extract submission and review workflow actions

**Files:**
- Create: `tests/Feature/Karya/KaryaWorkflowActionsTest.php`
- Create: `app/Actions/Karya/SubmitKaryaForReview.php`
- Create: `app/Actions/Karya/ReviewKaryaSubmission.php`
- Create: `app/Http/Requests/Admin/SubmitReviewKaryaRequest.php`
- Modify: `app/Http/Controllers/Seniman/KaryaSeniController.php`
- Modify: `app/Http/Controllers/Admin/KaryaSeniController.php`
- Modify: `resources/views/admin/karya/review.blade.php`

- [ ] **Step 1: Write the failing workflow-action tests**

```php
<?php

namespace Tests\Feature\Karya;

use App\Actions\Karya\ReviewKaryaSubmission;
use App\Actions\Karya\SubmitKaryaForReview;
use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryaWorkflowActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_action_marks_a_karya_as_diajukan(): void
    {
        $karya = KaryaSeni::factory()->draft()->create();

        $updated = app(SubmitKaryaForReview::class)->handle($karya);

        $this->assertSame(KaryaStatus::Diajukan, $updated->status_karya);
        $this->assertNotNull($updated->diajukan_pada);
    }

    public function test_review_action_publishes_an_approved_karya_and_records_history(): void
    {
        $admin = User::factory()->admin()->create();
        $karya = KaryaSeni::factory()->diajukan()->create();

        $updated = app(ReviewKaryaSubmission::class)->handle($admin, $karya, 'disetujui', 'Siap tayang');

        $this->assertSame(KaryaStatus::Dipublikasikan, $updated->status_karya);
        $this->assertNotNull($updated->disetujui_pada);
        $this->assertNotNull($updated->dipublikasikan_pada);

        $this->assertDatabaseHas('review_karya', [
            'karya_seni_id' => $karya->id,
            'admin_id' => $admin->id,
            'status_sebelum' => 'diajukan',
            'status_sesudah' => 'dipublikasikan',
            'catatan_review' => 'Siap tayang',
        ]);
    }
}
```

- [ ] **Step 2: Run the workflow tests and confirm the action classes do not exist yet**

Run:

```bash
rtk php artisan test tests/Feature/Karya/KaryaWorkflowActionsTest.php
```

Expected: FAIL with class-not-found errors for the action classes.

- [ ] **Step 3: Create the two karya workflow actions**

```php
<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use Illuminate\Validation\ValidationException;

class SubmitKaryaForReview
{
    public function handle(KaryaSeni $karya): KaryaSeni
    {
        if (! $karya->canBeSubmitted()) {
            throw ValidationException::withMessages([
                'status' => 'Karya tidak dapat diajukan untuk review.',
            ]);
        }

        $karya->update([
            'status_karya' => KaryaStatus::Diajukan->value,
            'diajukan_pada' => now(),
        ]);

        return $karya->refresh();
    }
}
```

```php
<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\ReviewKarya;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewKaryaSubmission
{
    public function handle(User $admin, KaryaSeni $karya, string $outcome, string $catatan): KaryaSeni
    {
        if ($karya->status_karya !== KaryaStatus::Diajukan) {
            throw ValidationException::withMessages([
                'status' => 'Karya harus berstatus diajukan sebelum direview.',
            ]);
        }

        return DB::transaction(function () use ($admin, $karya, $outcome, $catatan) {
            $statusSebelum = $karya->status_karya->value;
            $statusSesudah = match ($outcome) {
                'disetujui' => KaryaStatus::Dipublikasikan,
                'perlu_revisi' => KaryaStatus::PerluRevisi,
                'ditolak' => KaryaStatus::Ditolak,
                default => throw ValidationException::withMessages([
                    'status' => 'Status review tidak valid.',
                ]),
            };

            $payload = [
                'status_karya' => $statusSesudah->value,
                'catatan_admin_terbaru' => $catatan,
            ];

            if ($outcome === 'disetujui') {
                $payload['disetujui_pada'] = now();
                $payload['dipublikasikan_pada'] = now();
            }

            $karya->update($payload);

            ReviewKarya::create([
                'karya_seni_id' => $karya->id,
                'admin_id' => $admin->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => $statusSesudah->value,
                'catatan_review' => $catatan,
                'ditinjau_pada' => now(),
            ]);

            return $karya->refresh();
        });
    }
}
```

- [ ] **Step 4: Add the review request and slim both controllers down to orchestration**

```php
<?php

namespace App\Http\Requests\Admin;

use App\Enums\KaryaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitReviewKaryaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $karyaSeni = $this->route('karyaSeni');

        return $this->user()?->can('review', $karyaSeni) ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(KaryaStatus::reviewOutcomes())],
            'catatan_review' => ['required', 'string'],
        ];
    }
}
```

Replace the action-oriented methods in `app/Http/Controllers/Seniman/KaryaSeniController.php` with:

```php
use App\Actions\Karya\SubmitKaryaForReview;

public function ajukan(KaryaSeni $karyaSeni, SubmitKaryaForReview $action)
{
    $this->authorize('update', $karyaSeni);

    $action->handle($karyaSeni);

    return back()->with('success', 'Karya berhasil diajukan untuk review. Admin akan meninjau karya Anda.');
}
```

Replace the review-related methods in `app/Http/Controllers/Admin/KaryaSeniController.php` with:

```php
use App\Actions\Karya\ReviewKaryaSubmission;
use App\Http\Requests\Admin\SubmitReviewKaryaRequest;

public function review(KaryaSeni $karyaSeni)
{
    $this->authorize('review', $karyaSeni);

    $karyaSeni->load(['user.profilSeniman', 'kategori', 'mediaKarya']);

    return view('admin.karya.review', ['karya' => $karyaSeni]);
}

public function submitReview(SubmitReviewKaryaRequest $request, KaryaSeni $karyaSeni, ReviewKaryaSubmission $action)
{
    $action->handle(
        $request->user(),
        $karyaSeni,
        $request->validated('status'),
        $request->validated('catatan_review'),
    );

    return redirect()->route('admin.karya.index')->with('success', 'Review karya berhasil disimpan.');
}
```

Replace the form block in `resources/views/admin/karya/review.blade.php` with:

```blade
<form action="{{ route('admin.karya.submit-review', $karya) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label fw-bold">Status Review</label>
        <select name="status" class="form-select" required>
            <option value="">Pilih Status...</option>
            <option value="disetujui">Setuju - Dipublikasikan</option>
            <option value="perlu_revisi">Perlu Revisi</option>
            <option value="ditolak">Tolak</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Catatan untuk Seniman</label>
        <textarea name="catatan_review" class="form-control" rows="4" placeholder="Berikan catatan atau saran perbaikan..." required></textarea>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-2"></i> Submit Review
        </button>
    </div>
</form>
```

- [ ] **Step 5: Run the workflow tests again**

Run:

```bash
rtk php artisan test tests/Feature/Karya/KaryaWorkflowActionsTest.php tests/Feature/Karya/KaryaPolicyTest.php
```

Expected: PASS.

- [ ] **Step 6: Commit the extracted karya workflow**

```bash
rtk git add tests/Feature/Karya/KaryaWorkflowActionsTest.php app/Actions/Karya/SubmitKaryaForReview.php app/Actions/Karya/ReviewKaryaSubmission.php app/Http/Requests/Admin/SubmitReviewKaryaRequest.php app/Http/Controllers/Seniman/KaryaSeniController.php app/Http/Controllers/Admin/KaryaSeniController.php && rtk git commit -m "refactor: extract karya submission and review actions"
```

### Task 5: Move karya draft mutation and file lifecycle out of controllers

**Files:**
- Create: `tests/Feature/Karya/KaryaFileLifecycleTest.php`
- Create: `app/Actions/Files/ReplaceStoredFile.php`
- Create: `app/Actions/Files/DeleteStoredFiles.php`
- Create: `app/Actions/Karya/StoreUploadedKaryaMedia.php`
- Create: `app/Actions/Karya/CreateKaryaDraft.php`
- Create: `app/Actions/Karya/UpdateKaryaDraft.php`
- Create: `app/Actions/Karya/DeleteKaryaAssets.php`
- Create: `app/Http/Requests/Seniman/StoreKaryaRequest.php`
- Create: `app/Http/Requests/Seniman/UpdateKaryaRequest.php`
- Modify: `app/Http/Controllers/Seniman/KaryaSeniController.php`

- [ ] **Step 1: Write the failing file-lifecycle tests**

```php
<?php

namespace Tests\Feature\Karya;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\MediaKarya;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KaryaFileLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_a_thumbnail_replaces_the_old_file(): void
    {
        Storage::fake('public');

        $owner = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();
        $karya = KaryaSeni::factory()->for($owner)->for($kategori)->draft()->create([
            'thumbnail' => 'karya/thumbnails/old.webp',
        ]);

        Storage::disk('public')->put('karya/thumbnails/old.webp', 'old-image');

        $response = $this->actingAs($owner)->put(route('seniman.karya.update', $karya), [
            'judul_karya' => 'Judul Baru',
            'kategori_id' => $kategori->id,
            'deskripsi_singkat' => 'Ringkas',
            'deskripsi_lengkap' => 'Lengkap',
            'tahun_karya' => '2024',
            'media_karya' => 'Akrilik',
            'dimensi' => '50x50 cm',
            'lokasi_asal' => 'Sumbawa',
            'thumbnail' => UploadedFile::fake()->image('new.webp'),
        ]);

        $response->assertRedirect(route('seniman.karya.index'));

        $karya->refresh();

        Storage::disk('public')->assertMissing('karya/thumbnails/old.webp');
        Storage::disk('public')->assertExists($karya->thumbnail);
    }

    public function test_deleting_a_karya_removes_thumbnail_and_media_files(): void
    {
        Storage::fake('public');

        $owner = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();
        $karya = KaryaSeni::factory()->for($owner)->for($kategori)->draft()->create([
            'thumbnail' => 'karya/thumbnails/delete-me.webp',
        ]);

        Storage::disk('public')->put('karya/thumbnails/delete-me.webp', 'thumb');
        Storage::disk('public')->put('karya/media/delete-me.jpg', 'media');

        $media = MediaKarya::create([
            'karya_seni_id' => $karya->id,
            'jenis_media' => 'gambar',
            'nama_file' => 'delete-me.jpg',
            'path_file' => 'karya/media/delete-me.jpg',
            'ukuran_file' => 5,
            'urutan' => 0,
        ]);

        $response = $this->actingAs($owner)
            ->delete(route('seniman.karya.destroy', $karya));

        $response->assertRedirect(route('seniman.karya.index'));

        Storage::disk('public')->assertMissing('karya/thumbnails/delete-me.webp');
        Storage::disk('public')->assertMissing('karya/media/delete-me.jpg');
        $this->assertSoftDeleted('karya_seni', ['id' => $karya->id]);
        $this->assertDatabaseMissing('media_karya', ['id' => $media->id]);
    }
}
```

- [ ] **Step 2: Run the file-lifecycle tests and confirm the current controller leaves orphaned files**

Run:

```bash
rtk php artisan test tests/Feature/Karya/KaryaFileLifecycleTest.php
```

Expected: FAIL because the old thumbnail and media file are not removed by the current controller code.

- [ ] **Step 3: Create the reusable file and media actions**

```php
<?php

namespace App\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReplaceStoredFile
{
    public function handle(?string $currentPath, UploadedFile $uploadedFile, string $directory, string $disk = 'public'): string
    {
        $newPath = $uploadedFile->store($directory, $disk);

        if ($currentPath && Storage::disk($disk)->exists($currentPath)) {
            Storage::disk($disk)->delete($currentPath);
        }

        return $newPath;
    }
}
```

```php
<?php

namespace App\Actions\Files;

use Illuminate\Support\Facades\Storage;

class DeleteStoredFiles
{
    public function handle(array|string|null $paths, string $disk = 'public'): void
    {
        $paths = is_array($paths) ? $paths : [$paths];
        $paths = array_values(array_filter($paths));

        if ($paths !== []) {
            Storage::disk($disk)->delete($paths);
        }
    }
}
```

```php
<?php

namespace App\Actions\Karya;

use App\Models\KaryaSeni;
use App\Models\MediaKarya;
use Illuminate\Http\UploadedFile;

class StoreUploadedKaryaMedia
{
    public function handle(KaryaSeni $karya, array $files = []): void
    {
        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store('karya/media', 'public');

            MediaKarya::create([
                'karya_seni_id' => $karya->id,
                'jenis_media' => 'gambar',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'ukuran_file' => $file->getSize(),
                'urutan' => $karya->mediaKarya()->count() + $index,
            ]);
        }
    }
}
```

- [ ] **Step 4: Create the draft create, update, and delete actions**

```php
<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;

class CreateKaryaDraft
{
    public function __construct(private StoreUploadedKaryaMedia $storeUploadedKaryaMedia)
    {
    }

    public function handle(User $user, array $data): KaryaSeni
    {
        $thumbnailFile = $data['thumbnail'];
        $mediaFiles = $data['file_media'] ?? [];

        unset($data['thumbnail'], $data['file_media']);

        $karya = KaryaSeni::create([
            ...$data,
            'user_id' => $user->id,
            'thumbnail' => $thumbnailFile->store('karya/thumbnails', 'public'),
            'status_karya' => KaryaStatus::Draft->value,
        ]);

        $this->storeUploadedKaryaMedia->handle($karya, $mediaFiles);

        return $karya->load('mediaKarya');
    }
}
```

```php
<?php

namespace App\Actions\Karya;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\KaryaSeni;

class UpdateKaryaDraft
{
    public function __construct(
        private ReplaceStoredFile $replaceStoredFile,
        private StoreUploadedKaryaMedia $storeUploadedKaryaMedia,
    ) {
    }

    public function handle(KaryaSeni $karya, array $data): KaryaSeni
    {
        $thumbnailFile = $data['thumbnail'] ?? null;
        $mediaFiles = $data['file_media'] ?? [];

        unset($data['thumbnail'], $data['file_media']);

        if ($thumbnailFile) {
            $data['thumbnail'] = $this->replaceStoredFile->handle(
                $karya->thumbnail,
                $thumbnailFile,
                'karya/thumbnails',
            );
        }

        $karya->update($data);
        $this->storeUploadedKaryaMedia->handle($karya, $mediaFiles);

        return $karya->refresh();
    }
}
```

```php
<?php

namespace App\Actions\Karya;

use App\Actions\Files\DeleteStoredFiles;
use App\Models\KaryaSeni;

class DeleteKaryaAssets
{
    public function __construct(private DeleteStoredFiles $deleteStoredFiles)
    {
    }

    public function handle(KaryaSeni $karya): void
    {
        $karya->loadMissing('mediaKarya');

        $this->deleteStoredFiles->handle([
            $karya->thumbnail,
            ...$karya->mediaKarya->pluck('path_file')->all(),
        ]);

        $karya->mediaKarya()->delete();
    }
}
```

- [ ] **Step 5: Add the karya form requests and controller orchestration**

```php
<?php

namespace App\Http\Requests\Seniman;

use App\Models\KaryaSeni;
use Illuminate\Foundation\Http\FormRequest;

class StoreKaryaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', KaryaSeni::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'judul_karya' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'nullable|string',
            'tahun_karya' => 'nullable|string|max:20',
            'media_karya' => 'nullable|string|max:150',
            'dimensi' => 'nullable|string|max:100',
            'lokasi_asal' => 'nullable|string|max:150',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_media.*' => 'nullable|file|max:10240',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Seniman;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $karyaSeni = $this->route('karyaSeni');

        return $this->user()?->can('update', $karyaSeni) ?? false;
    }

    public function rules(): array
    {
        return [
            'judul_karya' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'nullable|string',
            'tahun_karya' => 'nullable|string|max:20',
            'media_karya' => 'nullable|string|max:150',
            'dimensi' => 'nullable|string|max:100',
            'lokasi_asal' => 'nullable|string|max:150',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_media.*' => 'nullable|file|max:10240',
        ];
    }
}
```

Replace the mutation methods in `app/Http/Controllers/Seniman/KaryaSeniController.php` with:

```php
use App\Actions\Karya\CreateKaryaDraft;
use App\Actions\Karya\DeleteKaryaAssets;
use App\Actions\Karya\UpdateKaryaDraft;
use App\Http\Requests\Seniman\StoreKaryaRequest;
use App\Http\Requests\Seniman\UpdateKaryaRequest;

public function store(StoreKaryaRequest $request, CreateKaryaDraft $action)
{
    $action->handle($request->user(), $request->validated());

    return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil ditambahkan sebagai draft.');
}

public function update(UpdateKaryaRequest $request, KaryaSeni $karyaSeni, UpdateKaryaDraft $action)
{
    $action->handle($karyaSeni, $request->validated());

    return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil diperbarui.');
}

public function destroy(KaryaSeni $karyaSeni, DeleteKaryaAssets $action)
{
    $this->authorize('delete', $karyaSeni);

    $action->handle($karyaSeni);
    $karyaSeni->delete();

    return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil dihapus.');
}
```

- [ ] **Step 6: Run the file-lifecycle tests again**

Run:

```bash
rtk php artisan test tests/Feature/Karya/KaryaFileLifecycleTest.php tests/Feature/Karya/KaryaWorkflowActionsTest.php
```

Expected: PASS.

- [ ] **Step 7: Commit the draft/file refactor**

```bash
rtk git add tests/Feature/Karya/KaryaFileLifecycleTest.php app/Actions/Files/ReplaceStoredFile.php app/Actions/Files/DeleteStoredFiles.php app/Actions/Karya/StoreUploadedKaryaMedia.php app/Actions/Karya/CreateKaryaDraft.php app/Actions/Karya/UpdateKaryaDraft.php app/Actions/Karya/DeleteKaryaAssets.php app/Http/Requests/Seniman/StoreKaryaRequest.php app/Http/Requests/Seniman/UpdateKaryaRequest.php app/Http/Controllers/Seniman/KaryaSeniController.php && rtk git commit -m "refactor: extract karya draft and file lifecycle logic"
```

### Task 6: Move public query logic out of controllers and views

**Files:**
- Create: `tests/Feature/Public/PublicArtistSearchTest.php`
- Create: `tests/Feature/Public/PublicLayoutComposerTest.php`
- Create: `app/View/Composers/PublicLayoutComposer.php`
- Modify: `app/Providers/AppServiceProvider.php`
- Modify: `app/Models/ProfilSeniman.php`
- Modify: `app/Models/KaryaSeni.php`
- Modify: `app/Http/Controllers/Public/SenimanController.php`
- Modify: `app/Http/Controllers/Public/KaryaController.php`
- Modify: `app/Http/Controllers/Public/HomeController.php`
- Modify: `resources/views/layouts/public.blade.php`

- [ ] **Step 1: Write the failing public-query tests**

```php
<?php

namespace Tests\Feature\Public;

use App\Models\ProfilSeniman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtistSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_search_does_not_return_inactive_profiles_when_only_nama_panggung_matches(): void
    {
        $inactiveUser = User::factory()->seniman()->nonaktif()->create([
            'nama' => 'Seniman Bocor',
        ]);

        ProfilSeniman::factory()->for($inactiveUser)->create([
            'nama_panggung' => 'Bocor Nonaktif',
            'bidang_seni_utama' => 'Lukis',
        ]);

        $response = $this->get('/seniman?q=' . urlencode('Bocor Nonaktif'));

        $response->assertOk();
        $response->assertDontSee('Bocor Nonaktif');
        $response->assertDontSee('Seniman Bocor');
    }
}
```

```php
<?php

namespace Tests\Feature\Public;

use App\Models\Kategori;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLayoutComposerTest extends TestCase
{
    use RefreshDatabase;

    public function test_composer_shares_sorted_active_categories(): void
    {
        Kategori::factory()->create([
            'nama_kategori' => 'Patung',
            'slug' => 'patung',
            'urutan' => 2,
            'status_aktif' => true,
        ]);

        Kategori::factory()->create([
            'nama_kategori' => 'Lukis',
            'slug' => 'lukis',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        Kategori::factory()->nonaktif()->create([
            'nama_kategori' => 'Arsip',
            'slug' => 'arsip',
            'urutan' => 0,
        ]);

        $view = view('welcome');

        (new PublicLayoutComposer())->compose($view);

        $items = $view->getData()['layoutKategoriList'];

        $this->assertSame(['Lukis', 'Patung'], $items->pluck('nama_kategori')->all());
    }
}
```

- [ ] **Step 2: Run the public-query tests and confirm the current code fails**

Run:

```bash
rtk php artisan test tests/Feature/Public/PublicArtistSearchTest.php tests/Feature/Public/PublicLayoutComposerTest.php
```

Expected: FAIL because the inactive artist still leaks through `orWhere`, and `PublicLayoutComposer` does not exist yet.

- [ ] **Step 3: Add the public layout composer and register it**

```php
<?php

namespace App\View\Composers;

use App\Models\Kategori;
use Illuminate\View\View;

class PublicLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with('layoutKategoriList', Kategori::aktif()->orderBy('urutan')->get());
    }
}
```

Replace the boot method in `app/Providers/AppServiceProvider.php` with:

```php
<?php

namespace App\Providers;

use App\Models\KaryaSeni;
use App\Policies\KaryaSeniPolicy;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(KaryaSeni::class, KaryaSeniPolicy::class);

        Gate::define('admin-access', fn ($user) => $user->isAdmin());
        Gate::define('seniman-access', fn ($user) => $user->isSeniman());

        View::composer('layouts.public', PublicLayoutComposer::class);
    }
}
```

- [ ] **Step 4: Add reusable scopes and update the public controllers and layout**

Replace the relevant parts of `app/Models/ProfilSeniman.php` with:

```php
public function scopePublik($query)
{
    return $query->whereHas('user', function ($userQuery) {
        $userQuery->where('status_akun', 'aktif')
            ->where('peran', 'seniman');
    });
}

public function scopeSearch($query, ?string $term)
{
    if (! filled($term)) {
        return $query;
    }

    return $query->where(function ($builder) use ($term) {
        $builder->whereHas('user', function ($userQuery) use ($term) {
            $userQuery->where('nama', 'like', '%' . $term . '%');
        })->orWhere('nama_panggung', 'like', '%' . $term . '%');
    });
}
```

Add this scope to `app/Models/KaryaSeni.php`:

```php
public function scopeSearch($query, ?string $term)
{
    if (! filled($term)) {
        return $query;
    }

    return $query->where(function ($builder) use ($term) {
        $builder->where('judul_karya', 'like', '%' . $term . '%')
            ->orWhere('deskripsi_singkat', 'like', '%' . $term . '%')
            ->orWhere('deskripsi_lengkap', 'like', '%' . $term . '%')
            ->orWhereHas('user', function ($userQuery) use ($term) {
                $userQuery->where('nama', 'like', '%' . $term . '%');
            });
    });
}
```

Replace `index()` in `app/Http/Controllers/Public/SenimanController.php` with:

```php
public function index(Request $request)
{
    $query = ProfilSeniman::publik()->with('user');

    if ($request->filled('bidang')) {
        $query->where('bidang_seni_utama', $request->bidang);
    }

    $query->search($request->q);

    $senimanList = $query->paginate(12);

    $bidangList = ProfilSeniman::select('bidang_seni_utama')
        ->distinct()
        ->pluck('bidang_seni_utama');

    return view('public.seniman.index', compact('senimanList', 'bidangList'));
}
```

Replace `index()` in `app/Http/Controllers/Public/KaryaController.php` with:

```php
public function index(Request $request)
{
    $query = KaryaSeni::publik()->with(['user.profilSeniman', 'kategori']);

    if ($request->filled('kategori')) {
        $query->whereHas('kategori', function ($kategoriQuery) use ($request) {
            $kategoriQuery->where('slug', $request->kategori);
        });
    }

    $query->search($request->q);

    $karyaList = $query->latest('dipublikasikan_pada')->paginate(12);
    $kategoriList = Kategori::aktif()->orderBy('urutan')->get();

    return view('public.karya.index', compact('karyaList', 'kategoriList'));
}
```

Replace the seniman search block in `app/Http/Controllers/Public/HomeController.php` with:

```php
$senimanResults = ProfilSeniman::publik()
    ->search($query)
    ->with('user')
    ->take(10)
    ->get();
```

Replace the inline query in `resources/views/layouts/public.blade.php` with:

```blade
@php
    $kategoriList = $layoutKategoriList;
@endphp
```

- [ ] **Step 5: Run the public-query tests again**

Run:

```bash
rtk php artisan test tests/Feature/Public/PublicArtistSearchTest.php tests/Feature/Public/PublicLayoutComposerTest.php
```

Expected: PASS.

- [ ] **Step 6: Commit the public query cleanup**

```bash
rtk git add tests/Feature/Public/PublicArtistSearchTest.php tests/Feature/Public/PublicLayoutComposerTest.php app/View/Composers/PublicLayoutComposer.php app/Providers/AppServiceProvider.php app/Models/ProfilSeniman.php app/Models/KaryaSeni.php app/Http/Controllers/Public/SenimanController.php app/Http/Controllers/Public/KaryaController.php app/Http/Controllers/Public/HomeController.php resources/views/layouts/public.blade.php && rtk git commit -m "refactor: move public query logic out of views"
```

### Task 7: Centralize dashboard stats and simplify the role middleware

**Files:**
- Create: `tests/Feature/Dashboard/DashboardStatsServiceTest.php`
- Create: `app/Services/Dashboard/BuildAdminDashboardStats.php`
- Create: `app/Services/Dashboard/BuildSenimanDashboardStats.php`
- Modify: `app/Http/Controllers/Admin/DashboardController.php`
- Modify: `app/Http/Controllers/Seniman/DashboardController.php`
- Modify: `app/Http/Controllers/Admin/SenimanController.php`
- Modify: `app/Http/Middleware/CheckRole.php`

- [ ] **Step 1: Write the failing stats-service tests**

```php
<?php

namespace Tests\Feature\Dashboard;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\User;
use App\Services\Dashboard\BuildAdminDashboardStats;
use App\Services\Dashboard\BuildSenimanDashboardStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_stats_builder_returns_expected_counts(): void
    {
        $seniman = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();

        KaryaSeni::factory()->for($seniman)->for($kategori)->diajukan()->create();
        KaryaSeni::factory()->for($seniman)->for($kategori)->perluRevisi()->create();
        KaryaSeni::factory()->for($seniman)->for($kategori)->dipublikasikan()->create();

        $stats = app(BuildAdminDashboardStats::class)->handle();

        $this->assertSame(1, $stats['totalSeniman']);
        $this->assertSame(3, $stats['totalKarya']);
        $this->assertSame(1, $stats['karyaMenunggu']);
        $this->assertSame(1, $stats['karyaPerluRevisi']);
        $this->assertSame(1, $stats['karyaDipublikasikan']);
        $this->assertSame(1, $stats['kategoriAktif']);
    }

    public function test_seniman_dashboard_stats_builder_returns_expected_counts_for_one_artist(): void
    {
        $user = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();

        KaryaSeni::factory()->for($user)->for($kategori)->draft()->create();
        KaryaSeni::factory()->for($user)->for($kategori)->diajukan()->create();
        KaryaSeni::factory()->for($user)->for($kategori)->dipublikasikan()->create();

        $stats = app(BuildSenimanDashboardStats::class)->handle($user);

        $this->assertSame(3, $stats['total']);
        $this->assertSame(1, $stats['draft']);
        $this->assertSame(1, $stats['diajukan']);
        $this->assertSame(0, $stats['perlu_revisi']);
        $this->assertSame(0, $stats['ditolak']);
        $this->assertSame(1, $stats['dipublikasikan']);
    }
}
```

- [ ] **Step 2: Run the stats tests and confirm the services do not exist yet**

Run:

```bash
rtk php artisan test tests/Feature/Dashboard/DashboardStatsServiceTest.php
```

Expected: FAIL with class-not-found errors for the stats services.

- [ ] **Step 3: Create the stats services and update the dashboard controllers**

```php
<?php

namespace App\Services\Dashboard;

use App\Enums\KaryaStatus;
use App\Models\Kategori;
use App\Models\KaryaSeni;
use App\Models\User;

class BuildAdminDashboardStats
{
    public function handle(): array
    {
        return [
            'totalSeniman' => User::where('peran', 'seniman')->where('status_akun', 'aktif')->count(),
            'totalKarya' => KaryaSeni::count(),
            'karyaMenunggu' => KaryaSeni::where('status_karya', KaryaStatus::Diajukan->value)->count(),
            'karyaPerluRevisi' => KaryaSeni::where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
            'karyaDipublikasikan' => KaryaSeni::where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
            'kategoriAktif' => Kategori::where('status_aktif', true)->count(),
        ];
    }
}
```

```php
<?php

namespace App\Services\Dashboard;

use App\Enums\KaryaStatus;
use App\Models\User;

class BuildSenimanDashboardStats
{
    public function handle(User $user): array
    {
        return [
            'total' => $user->karyaSeni()->count(),
            'draft' => $user->karyaSeni()->where('status_karya', KaryaStatus::Draft->value)->count(),
            'diajukan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Diajukan->value)->count(),
            'perlu_revisi' => $user->karyaSeni()->where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
            'ditolak' => $user->karyaSeni()->where('status_karya', KaryaStatus::Ditolak->value)->count(),
            'dipublikasikan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
        ];
    }
}
```

Replace `index()` in `app/Http/Controllers/Admin/DashboardController.php` with:

```php
use App\Services\Dashboard\BuildAdminDashboardStats;

public function index(BuildAdminDashboardStats $buildAdminDashboardStats)
{
    $stats = $buildAdminDashboardStats->handle();

    $karyaTerbaru = KaryaSeni::with(['user', 'kategori'])
        ->latest()
        ->take(5)
        ->get();

    $menungguReview = KaryaSeni::where('status_karya', 'diajukan')
        ->with(['user', 'kategori'])
        ->latest('diajukan_pada')
        ->take(5)
        ->get();

    $reviewTerbaru = ReviewKarya::with(['karyaSeni', 'admin'])
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', array_merge($stats, [
        'karyaTerbaru' => $karyaTerbaru,
        'menungguReview' => $menungguReview,
        'reviewTerbaru' => $reviewTerbaru,
    ]));
}
```

Replace `index()` in `app/Http/Controllers/Seniman/DashboardController.php` with:

```php
use App\Services\Dashboard\BuildSenimanDashboardStats;

public function index(BuildSenimanDashboardStats $buildSenimanDashboardStats)
{
    $user = auth()->user();
    $statistik = $buildSenimanDashboardStats->handle($user);

    $karyaTerbaru = $user->karyaSeni()
        ->with('kategori')
        ->latest()
        ->take(5)
        ->get();

    return view('seniman.dashboard', compact('statistik', 'karyaTerbaru'));
}
```

Replace the statistik block in `app/Http/Controllers/Admin/SenimanController.php` with:

```php
use App\Enums\KaryaStatus;

$statistik = [
    'total_karya' => $user->karyaSeni()->count(),
    'dipublikasikan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
    'menunggu_review' => $user->karyaSeni()->where('status_karya', KaryaStatus::Diajukan->value)->count(),
    'perlu_revisi' => $user->karyaSeni()->where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
];
```

- [ ] **Step 4: Simplify `app/Http/Middleware/CheckRole.php` so it stops logging every request**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->isAktif()) {
            auth()->logout();

            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        if ($role === 'admin' && ! $user->isAdmin()) {
            return $user->isSeniman()
                ? redirect()->route('seniman.dashboard')->with('error', 'Akses ditolak.')
                : abort(403, 'Akses ditolak.');
        }

        if ($role === 'seniman' && ! $user->isSeniman()) {
            return $user->isAdmin()
                ? redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.')
                : abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
```

- [ ] **Step 5: Run the dashboard and access tests again**

Run:

```bash
rtk php artisan test tests/Feature/Dashboard/DashboardStatsServiceTest.php tests/Feature/Auth/RoleAreaAccessTest.php
```

Expected: PASS.

- [ ] **Step 6: Commit the dashboard and middleware cleanup**

```bash
rtk git add tests/Feature/Dashboard/DashboardStatsServiceTest.php app/Services/Dashboard/BuildAdminDashboardStats.php app/Services/Dashboard/BuildSenimanDashboardStats.php app/Http/Controllers/Admin/DashboardController.php app/Http/Controllers/Seniman/DashboardController.php app/Http/Middleware/CheckRole.php && rtk git commit -m "refactor: centralize dashboard stats and simplify role middleware"
```

### Task 8: Apply the request-action pattern to kategori, slider, and kata sambutan

**Files:**
- Create: `tests/Feature/Admin/SupportingCrudRefactorTest.php`
- Create: `app/Http/Requests/Admin/StoreKategoriRequest.php`
- Create: `app/Http/Requests/Admin/UpdateKategoriRequest.php`
- Create: `app/Http/Requests/Admin/StoreSliderRequest.php`
- Create: `app/Http/Requests/Admin/UpdateSliderRequest.php`
- Create: `app/Http/Requests/Admin/StoreKataSambutanRequest.php`
- Create: `app/Http/Requests/Admin/UpdateKataSambutanRequest.php`
- Create: `app/Actions/Admin/SaveKategori.php`
- Create: `app/Actions/Admin/SaveSlider.php`
- Create: `app/Actions/Admin/SaveKataSambutan.php`
- Modify: `app/Http/Controllers/Admin/KategoriController.php`
- Modify: `app/Http/Controllers/Admin/SliderController.php`
- Modify: `app/Http/Controllers/Admin/KataSambutanController.php`

- [ ] **Step 1: Write the failing supporting-CRUD tests**

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\KataSambutan;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupportingCrudRefactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_slider_update_replaces_the_previous_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        Storage::disk('public')->put('sliders/old.webp', 'old-slider');

        $slider = Slider::create([
            'judul' => 'Slider Lama',
            'subjudul' => 'Subjudul',
            'gambar' => 'sliders/old.webp',
            'tautan' => '/karya',
            'teks_tombol' => 'Lihat',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.slider.update', $slider), [
            'judul' => 'Slider Baru',
            'subjudul' => 'Subjudul Baru',
            'gambar' => UploadedFile::fake()->image('new.webp'),
            'tautan' => '/profil',
            'teks_tombol' => 'Buka',
            'urutan' => 2,
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.slider.index'));

        $slider->refresh();

        Storage::disk('public')->assertMissing('sliders/old.webp');
        Storage::disk('public')->assertExists($slider->gambar);
    }

    public function test_storing_an_active_kata_sambutan_deactivates_the_previous_active_record(): void
    {
        $admin = User::factory()->admin()->create();

        $existing = KataSambutan::create([
            'judul' => 'Sambutan Lama',
            'nama_tokoh' => 'Tokoh Lama',
            'jabatan' => 'Ketua',
            'foto' => null,
            'isi_sambutan' => 'Isi lama',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.kata-sambutan.store'), [
            'judul' => 'Sambutan Baru',
            'nama_tokoh' => 'Tokoh Baru',
            'jabatan' => 'Bupati',
            'isi_sambutan' => 'Isi baru',
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.kata-sambutan.index'));

        $this->assertFalse($existing->fresh()->status_aktif);
        $this->assertTrue(KataSambutan::latest('id')->first()->status_aktif);
    }

    public function test_storing_a_category_without_a_slug_generates_one(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.kategori.store'), [
            'nama_kategori' => 'Seni Anyar',
            'deskripsi' => 'Kategori baru',
            'ikon' => 'bi bi-palette',
            'urutan' => 3,
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseHas('kategori', [
            'nama_kategori' => 'Seni Anyar',
            'slug' => 'seni-anyar',
        ]);
    }
}
```

- [ ] **Step 2: Run the supporting-CRUD tests and confirm slider file replacement still fails**

Run:

```bash
rtk php artisan test tests/Feature/Admin/SupportingCrudRefactorTest.php
```

Expected: FAIL because the slider controller does not remove the old image file yet.

- [ ] **Step 3: Add the admin form requests**

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|max:100|unique:kategori',
            'slug' => 'nullable|string|max:120|unique:kategori',
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $kategori = $this->route('kategori');

        return [
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
            'slug' => 'nullable|string|max:120|unique:kategori,slug,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'subjudul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKataSambutanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'nama_tokoh' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'isi_sambutan' => 'required|string',
            'status_aktif' => 'boolean',
        ];
    }
}
```

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKataSambutanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'nama_tokoh' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'isi_sambutan' => 'required|string',
            'status_aktif' => 'boolean',
        ];
    }
}
```

- [ ] **Step 4: Add the save actions and update the three admin controllers**

```php
<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\Kategori;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SaveKategori
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?Kategori $kategori = null): Kategori
    {
        $kategori ??= new Kategori();

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['nama_kategori']);
        }

        if (($data['gambar'] ?? null) instanceof UploadedFile) {
            $data['gambar'] = $this->replaceStoredFile->handle($kategori->gambar, $data['gambar'], 'kategori');
        } else {
            unset($data['gambar']);
        }

        $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

        $kategori->fill($data)->save();

        return $kategori;
    }
}
```

```php
<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\Slider;
use Illuminate\Http\UploadedFile;

class SaveSlider
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?Slider $slider = null): Slider
    {
        $slider ??= new Slider();

        if (($data['gambar'] ?? null) instanceof UploadedFile) {
            $data['gambar'] = $this->replaceStoredFile->handle($slider->gambar, $data['gambar'], 'sliders');
        } else {
            unset($data['gambar']);
        }

        $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

        $slider->fill($data)->save();

        return $slider;
    }
}
```

```php
<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\KataSambutan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SaveKataSambutan
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?KataSambutan $kataSambutan = null): KataSambutan
    {
        $kataSambutan ??= new KataSambutan();

        return DB::transaction(function () use ($data, $kataSambutan) {
            if (($data['foto'] ?? null) instanceof UploadedFile) {
                $data['foto'] = $this->replaceStoredFile->handle($kataSambutan->foto, $data['foto'], 'sambutan');
            } else {
                unset($data['foto']);
            }

            $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

            if ($data['status_aktif']) {
                KataSambutan::query()
                    ->when($kataSambutan->exists, fn ($query) => $query->whereKeyNot($kataSambutan->id))
                    ->where('status_aktif', true)
                    ->update(['status_aktif' => false]);
            }

            $kataSambutan->fill($data)->save();

            return $kataSambutan;
        });
    }
}
```

Replace `store()`, `update()`, and `destroy()` in `app/Http/Controllers/Admin/KategoriController.php` with:

```php
use App\Actions\Admin\SaveKategori;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Requests\Admin\StoreKategoriRequest;
use App\Http\Requests\Admin\UpdateKategoriRequest;

public function store(StoreKategoriRequest $request, SaveKategori $saveKategori)
{
    $saveKategori->handle($request->validated());

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
}

public function update(UpdateKategoriRequest $request, Kategori $kategori, SaveKategori $saveKategori)
{
    $saveKategori->handle($request->validated(), $kategori);

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
}

public function destroy(Kategori $kategori, DeleteStoredFiles $deleteStoredFiles)
{
    if ($kategori->karyaSeni()->count() > 0) {
        return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki karya.');
    }

    $deleteStoredFiles->handle($kategori->gambar);
    $kategori->delete();

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
}
```

Replace `store()`, `update()`, and `destroy()` in `app/Http/Controllers/Admin/SliderController.php` with:

```php
use App\Actions\Admin\SaveSlider;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;

public function store(StoreSliderRequest $request, SaveSlider $saveSlider)
{
    $saveSlider->handle($request->validated());

    return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
}

public function update(UpdateSliderRequest $request, Slider $slider, SaveSlider $saveSlider)
{
    $saveSlider->handle($request->validated(), $slider);

    return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
}

public function destroy(Slider $slider, DeleteStoredFiles $deleteStoredFiles)
{
    $deleteStoredFiles->handle($slider->gambar);
    $slider->delete();

    return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
}
```

Replace `store()`, `update()`, and `destroy()` in `app/Http/Controllers/Admin/KataSambutanController.php` with:

```php
use App\Actions\Admin\SaveKataSambutan;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Requests\Admin\StoreKataSambutanRequest;
use App\Http\Requests\Admin\UpdateKataSambutanRequest;

public function store(StoreKataSambutanRequest $request, SaveKataSambutan $saveKataSambutan)
{
    $saveKataSambutan->handle($request->validated());

    return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil ditambahkan.');
}

public function update(UpdateKataSambutanRequest $request, KataSambutan $kataSambutan, SaveKataSambutan $saveKataSambutan)
{
    $saveKataSambutan->handle($request->validated(), $kataSambutan);

    return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil diperbarui.');
}

public function destroy(KataSambutan $kataSambutan, DeleteStoredFiles $deleteStoredFiles)
{
    $deleteStoredFiles->handle($kataSambutan->foto);
    $kataSambutan->delete();

    return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil dihapus.');
}
```

- [ ] **Step 5: Run the supporting-CRUD tests again**

Run:

```bash
rtk php artisan test tests/Feature/Admin/SupportingCrudRefactorTest.php
```

Expected: PASS.

- [ ] **Step 6: Commit the supporting admin CRUD refactor**

```bash
rtk git add tests/Feature/Admin/SupportingCrudRefactorTest.php app/Http/Requests/Admin/StoreKategoriRequest.php app/Http/Requests/Admin/UpdateKategoriRequest.php app/Http/Requests/Admin/StoreSliderRequest.php app/Http/Requests/Admin/UpdateSliderRequest.php app/Http/Requests/Admin/StoreKataSambutanRequest.php app/Http/Requests/Admin/UpdateKataSambutanRequest.php app/Actions/Admin/SaveKategori.php app/Actions/Admin/SaveSlider.php app/Actions/Admin/SaveKataSambutan.php app/Http/Controllers/Admin/KategoriController.php app/Http/Controllers/Admin/SliderController.php app/Http/Controllers/Admin/KataSambutanController.php && rtk git commit -m "refactor: apply request-action pattern to admin CRUD"
```

## Final Verification

After Task 8, run the focused suite that covers every refactored seam:

```bash
rtk php artisan test tests/Feature/Factories/FactorySmokeTest.php tests/Feature/Auth/RoleAreaAccessTest.php tests/Feature/Karya/KaryaPolicyTest.php tests/Unit/Karya/KaryaStatusTest.php tests/Feature/Karya/KaryaWorkflowActionsTest.php tests/Feature/Karya/KaryaFileLifecycleTest.php tests/Feature/Public/PublicArtistSearchTest.php tests/Feature/Public/PublicLayoutComposerTest.php tests/Feature/Dashboard/DashboardStatsServiceTest.php tests/Feature/Admin/SupportingCrudRefactorTest.php
```

Expected: PASS.

Then run the full test suite:

```bash
rtk php artisan test
```

Expected: PASS.
