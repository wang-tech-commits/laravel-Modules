<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasCovers
{

    /**
     * 获取封面图片字段（单图）
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return string
     */
    public function getCoverField(): string
    {
        return $this->cover_field ?? 'cover';
    }

    /**
     * 获取图片字段（多图）
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return string
     */
    public function getPicturesField(): string
    {
        return $this->pictures_field ?? 'pictures';
    }

    /**
     * 解析单图地址
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return string
     */
    public function getCoverUrlAttribute(): string
    {
        $cover = $this->getAttribute($this->getCoverField());

        return $this->parseImageUrl($cover);
    }

    /**
     * 解析多图地址
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return array
     */
    public function getPicturesUrlAttribute(): array
    {
        $pictures = $this->getAttribute($this->getPicturesField());

        if (empty($pictures)) {
            return [];
        }

        return collect($pictures)->map(function ($picture) {
            return $this->parseImageUrl($picture);
        })->toArray();
    }

    /**
     * 解析图片文件的实际展示地址
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @param string $image [description]
     * @return string
     */
    protected function parseImageUrl(?string $image): string
    {
        if (empty($image)) {
            return '';
        } elseif (Str::startsWith($image, 'http')) {
            return $image;
        } else {
            return Storage::url($image);
        }
    }

}
