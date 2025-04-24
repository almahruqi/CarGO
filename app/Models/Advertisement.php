<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->hasOne(Car::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('order');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query): void
    {
        $query->where('status', 'rejected');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhereHas('car', function ($query) use ($search) {
                        $query->where('make', 'like', '%'.$search.'%')
                            ->orWhere('model', 'like', '%'.$search.'%');
                    });
            });
        });

        $query->when($filters['min_price'] ?? null, function ($query, $price) {
            $query->where('price', '>=', $price);
        });

        $query->when($filters['max_price'] ?? null, function ($query, $price) {
            $query->where('price', '<=', $price);
        });

        $query->when($filters['make'] ?? null, function ($query, $make) {
            $query->whereHas('car', function ($query) use ($make) {
                $query->where('make', $make);
            });
        });

        $query->when($filters['model'] ?? null, function ($query, $model) {
            $query->whereHas('car', function ($query) use ($model) {
                $query->where('model', $model);
            });
        });
    }

    protected static function booted()
    {
        static::creating(function ($advertisement) {
            $advertisement->user_id = auth()->id();
        });

        static::updating(function ($advertisement) {
            if ($advertisement->isDirty() && $advertisement->status === 'approved') {
                $advertisement->status = 'pending';
            }
        });
    }
} 