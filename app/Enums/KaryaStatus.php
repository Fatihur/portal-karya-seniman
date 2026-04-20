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
