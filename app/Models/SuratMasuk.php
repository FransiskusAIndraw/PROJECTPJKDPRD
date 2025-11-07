<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'file_surat',
        'status',
        'status_screening',
        'catatan_screening',
        'catatan_tusekwan',
        'created_by',
        'reviewed_by',
        'screened_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===================== STATUS CONSTANTS =====================
    public const STATUS_DRAFT = 'draft';
    public const STATUS_TERKIRIM_KE_TUSEKWAN = 'terkirim_ke_tusekwan';
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const STATUS_PERLU_REVISI = 'perlu_revisi';
    public const STATUS_TERVERIFIKASI = 'terverifikasi';
    public const STATUS_DIDISPOSISIKAN_KE_PIMPINAN = 'didisposisikan_ke_pimpinan';
    public const STATUS_DITERIMA_PIMPINAN = 'diterima_pimpinan';
    public const STATUS_DIDISPOSISIKAN_OLEH_PIMPINAN = 'didisposisikan_oleh_pimpinan';
    public const STATUS_DITERIMA_SEKWAN = 'diterima_sekwan';
    public const STATUS_DITERUSKAN_KE_KABAG = 'diteruskan_ke_kabag';
    public const STATUS_DITERUSKAN_KE_TUSEKRE = 'diteruskan_ke_tusekre';
    public const STATUS_DITERIMA_KABAG = 'diterima_kabag';
    public const STATUS_SELESAI_DIPROSES = 'selesai_diproses';
    public const STATUS_DIARSIPKAN = 'diarsipkan';
    public const STATUS_DIHAPUS = 'dihapus';

    public const SCREENING_PENDING = 'pending';
    public const SCREENING_APPROVED = 'approved';
    public const SCREENING_REJECTED = 'rejected';

    // ===================== RELATIONS =====================
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function screener() { return $this->belongsTo(User::class, 'screened_by'); }

    // ===================== SCOPES =====================
    public function scopeDraft($q) { return $q->where('status', self::STATUS_DRAFT); }
    public function scopeMenungguVerifikasi($q) { return $q->where('status', self::STATUS_MENUNGGU_VERIFIKASI); }
    public function scopePerluRevisi($q) { return $q->where('status', self::STATUS_PERLU_REVISI); }

    // ===================== TRANSITIONS =====================

    /** TU Sekre mengirim surat baru ke TU Sekwan */
    public function markTerkirimKeTUSekwan(?int $byUserId = null)
    {
        $this->update([
            'status' => self::STATUS_TERKIRIM_KE_TUSEKWAN,
            'status_screening' => self::SCREENING_PENDING,
            'created_by' => $this->created_by ?? ($byUserId ?? auth()->id()),
        ]);
        return $this;
    }

    /** TU Sekwan menerima dari TU Sekre dan tandai menunggu verifikasi */
    public function markMenungguVerifikasi()
    {
        $this->update([
            'status' => self::STATUS_MENUNGGU_VERIFIKASI,
            'status_screening' => self::SCREENING_PENDING,
        ]);
        return $this;
    }

    /** TU Sekwan menolak verifikasi → kembali ke TU Sekre */
    public function markPerluRevisi(?string $note = null, ?int $byUserId = null)
    {
        $this->update([
            'status' => self::STATUS_PERLU_REVISI,
            'status_screening' => self::SCREENING_REJECTED,
            'catatan_tusekwan' => $note,   // catatan dari TU Sekwan
            'catatan_screening' => $note,  // simpan juga ke catatan screening agar kompatibel
            'screened_by' => $byUserId ?? auth()->id(),
            'reviewed_by' => $byUserId ?? auth()->id(),
        ]);
        return $this;
    }

    /** TU Sekwan menyetujui verifikasi */
    public function markTerverifikasi(?string $note = null, ?int $byUserId = null)
    {
        $this->update([
            'status' => self::STATUS_TERVERIFIKASI,
            'status_screening' => self::SCREENING_APPROVED,
            'catatan_tusekwan' => $note,
            'catatan_screening' => $note,
            'screened_by' => $byUserId ?? auth()->id(),
            'reviewed_by' => $byUserId ?? auth()->id(),
        ]);
        return $this;
    }

    /** TU Sekre mengirim ulang setelah revisi */
    public function markKirimUlangSetelahRevisi(?int $byUserId = null)
    {
        $this->update([
            'status' => self::STATUS_TERKIRIM_KE_TUSEKWAN,
            'status_screening' => self::SCREENING_PENDING,
            'catatan_tusekwan' => null,
            'catatan_screening' => null,
            'reviewed_by' => null,
            'screened_by' => null,
        ]);
        return $this;
    }

    // ===================== LABEL UTILITY =====================
    public static function statusLabel(string $status): string
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_TERKIRIM_KE_TUSEKWAN => 'Terkirim ke TU Sekwan',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_PERLU_REVISI => 'Perlu Revisi',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_DIDISPOSISIKAN_KE_PIMPINAN => 'Didisposisikan ke Pimpinan',
            self::STATUS_DITERIMA_SEKWAN => 'Diterima Sekwan',
            self::STATUS_DITERUSKAN_KE_KABAG => 'Diteruskan ke Kabag',
            self::STATUS_DITERUSKAN_KE_TUSEKRE => 'Diteruskan ke TU Sekre',
            self::STATUS_DIARSIPKAN => 'Diarsipkan',
        ][$status] ?? ucfirst($status);
    }

    // Auto uppercase nomor surat
    public function getNomorSuratAttribute($value)
    {
        return $value ? strtoupper($value) : $value;
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_id');
    }

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'surat_id');
    }
}
