<?php

namespace App\Traits;

trait DataStatus
{
    /**
     * 正常显示的数据
     * @Author:<Mr.Wang>
     * @Date:2021-04-09
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopeShown($query)
    {
        return $query->where('status', 1);
    }

    /**
     * 不显示的数据
     * @Author:<Mr.Wang>
     * @Date:2021-04-09
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopeUnShown($query)
    {
        return $query->where('status', 0);
    }

    public function getStatusTextAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return '禁用';
            case 1:
                return '正常';
            case 2:
                return '待审核';
            default:
                return '未知';
        }
    }
}
