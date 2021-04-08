<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * 预期给所有拥有浏览计数的模型使用
 * 使用缓存，计算浏览量，定期更新缓存至数据库中
 */
trait HasClicks
{

    protected $saveRate = 20;

    /**
     * 获取点击量的字段
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return string
     */
    private function getClicksField(): string
    {
        return $this->clicks_field ?? 'clicks';
    }

    /**
     * 获取缓存前缀
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return string
     */
    private function getCachePrefix(): string
    {
        return $this->cachePrefix ?? class_basename(__CLASS__);
    }

    /**
     * 生成一个缓存KEY
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @param [type] $appends [description]
     * @return string
     */
    private function getCacheKey($appends = null): string
    {
        return $this->getCachePrefix() . ':' . $this->getKey() . ':' . $appends;
    }

    /**
     * 增加点击量
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @param int|integer $step
     * @return [type] [description]
     */
    public function incrementClicks(int $step = 1)
    {
        Cache::increment($this->getCacheKey('clicks'), $step);

        if (rand(1, $this->saveRate) === 1) {
            $this->update([$this->getClicksField() => $this->clicks]);
        }
    }

    /**
     * 获取缓存的浏览次数
     * @Author:<Mr.Wang>
     * @Date:2021-04-07
     * @return [type] [description]
     */
    public function getClicksAttribute(): int
    {
        $clicks = Cache::get($this->getCacheKey('clicks'));

        if (is_null($clicks)) {
            return Cache::rememberForever($this->getCacheKey('clicks'), function () {
                return $this->getAttributes()[$this->getClicksField()];
            });
        } else {
            return $clicks;
        }
    }

}
