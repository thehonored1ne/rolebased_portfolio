<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'avatar_url',
        'resume_url',
        'contact_email',
        'location',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }
}
