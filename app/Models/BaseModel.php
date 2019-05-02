<?php

namespace App\Models;

use App\Filters\QueryFilters;
use App\Utils\Traits\UserSessionAttributes;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    use UserSessionAttributes;
    use SoftDeletes;

    public function __call($method, $params)
    {
        $entity = strtolower(class_basename($this));

        if ($entity) {
            $configPath = "modules.relations.$entity.$method";

            if (config()->has($configPath)) {
                $function = config()->get($configPath);

				return call_user_func_array(array($this, $function[0]), $function[1]);
            }
        }

        return parent::__call($method, $params);
    }

    public function scopeCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
        return $query;
    }

    public function scopeScope($query)
    {

        $query->where($this->getTable() .'.company_id', '=', auth()->user()->company()->id);

        return $query;
    }

}