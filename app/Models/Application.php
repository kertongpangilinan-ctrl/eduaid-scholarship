<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';
    protected $table = 'applications';

    protected $fillable = [
        'user_id', 'batch_id', 'reviewed_by', 'reference_number', 'status',
        'admin_notes', 'rejection_reason', 'submission_date', 'reviewed_at'
    ];

    protected $casts = [
        'submission_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function isComplete()
    {
        $requiredDocuments = [
            'proof_of_residency', 'picture_2x2', 'school_id_front', 'school_id_back',
            'letter_of_intent', 'recent_grades', 'signature', 'cor_coe'
        ];

        $uploadedDocuments = $this->user->documents->pluck('document_type')->toArray();
        $missingDocuments = array_diff($requiredDocuments, $uploadedDocuments);

        return empty($missingDocuments);
    }

    public function getProgressPercentage()
    {
        $requiredDocuments = 8;
        $uploadedCount = $this->user->documents->count();

        $statusWeight = [
            'pending' => 10,
            'under_review' => 50,
            'requires_action' => 30,
            'approved' => 100,
            'rejected' => 100,
        ];

        $documentProgress = ($uploadedCount / $requiredDocuments) * 60;
        $statusProgress = $statusWeight[$this->status] ?? 0;

        return min(100, $documentProgress + $statusProgress);
    }
}
