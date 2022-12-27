<?php

declare(strict_types=1);

namespace Domain\UseCase\Tag;

use App\Adapter\Presenter\Tag\StoreTagPresenter;
use Domain\Repository\TagRepositoryInterface;

/**
 * StoreTag class
 */
final class StoreTag
{
    /**
     * コンストラクタ
     *
     * @param TagRepositoryInterface tagRepository
     */
    public function __construct(private TagRepositoryInterface $tagRepository)
    {
    }

    /**
     * @param string $name
     * @return array
     */
    public function __invoke(string $name): array
    {
        $tag = $this->tagRepository->findByName($name);

        if (is_null($tag)) {
            $tag = $this->tagRepository->save($name);
        }

        return (new StoreTagPresenter($tag))->toArray();
    }
}
