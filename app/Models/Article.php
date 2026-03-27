<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = ['title','subtitle','body','author_id'];


    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,"author_id","id");
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class,"views","article_id","user_id");
    }

    public function raters(): BelongsToMany
    {
        return $this->belongsToMany(User::class,"rates","article_id","user_id")->withPivot('rate');
    }
}
