<?php

namespace App\Traits;

use App\Services\AuditLogService;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            if (get_class($model) !== 'App\Models\AuditLog') {
                AuditLogService::logCreate(class_basename($model), $model);
            }
        });

        static::updated(function ($model) {
            if (get_class($model) !== 'App\Models\AuditLog') {
                $old = $model->getOriginal();
                $new = $model->getAttributes();
                
                $changedOld = [];
                $changedNew = [];
                
                foreach ($new as $key => $value) {
                    if (isset($old[$key]) && $old[$key] != $value) {
                        if (!in_array($key, ['password', 'otp_code', 'remember_token'])) {
                            $changedOld[$key] = $old[$key];
                            $changedNew[$key] = $value;
                        }
                    }
                }
                
                if (!empty($changedNew)) {
                    AuditLogService::logUpdate(class_basename($model), $model, $changedOld);
                }
            }
        });

        static::deleted(function ($model) {
            if (get_class($model) !== 'App\Models\AuditLog') {
                AuditLogService::logDelete(class_basename($model), $model);
            }
        });
    }
}