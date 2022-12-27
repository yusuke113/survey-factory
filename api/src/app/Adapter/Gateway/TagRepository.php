<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\Tag;
use Domain\Repository\TagRepositoryInterface;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * TagRepository class
 */
final class TagRepository implements TagRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findByName(string $name): ?Tag
    {
        return Tag::where('name', $name)->first();
    }

    /**
     * @inheritDoc
     */
    public function save(string $name): Tag
    {
        $tag = new Tag();
        $tag->uuid = (string) Str::uuid();
        $tag->name = $name;

        try {
            $tag->save();
        } catch (RuntimeException $exception) {
            throw $exception;
        }

        return $tag;
    }
}
