<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    public static function log($action, $entityType, $entityId, $oldValues = null, $newValues = null)
    {
        try {
            $user = auth()->user();
            
            $data = [
                'user_id' => $user ? $user->id : null,
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'created_at' => now()
            ];
            
            if ($oldValues !== null) {
                $data['old_values'] = is_array($oldValues) ? $oldValues : $oldValues->toArray();
            }
            
            if ($newValues !== null) {
                $data['new_values'] = is_array($newValues) ? $newValues : $newValues->toArray();
            }
            
            AuditLog::create($data);
            
        } catch (\Exception $e) {
            Log::error('Failed to create audit log: ' . $e->getMessage());
        }
    }

    public static function logCreate($entityType, $entity)
    {
        self::log('create', $entityType, $entity->id, null, $entity->toArray());
    }

    public static function logUpdate($entityType, $entity, $oldValues)
    {
        self::log('update', $entityType, $entity->id, $oldValues, $entity->toArray());
    }

    public static function logDelete($entityType, $entity)
    {
        self::log('delete', $entityType, $entity->id, $entity->toArray(), null);
    }

    public static function logLogin($user)
    {
        self::log('login', 'User', $user->id, null, ['email' => $user->email]);
    }

    public static function logLogout($user)
    {
        self::log('logout', 'User', $user->id, null, ['email' => $user->email]);
    }

    public static function logApprove($entityType, $entity)
    {
        self::log('approve', $entityType, $entity->id, null, ['status' => 'approved']);
    }

    public static function logReject($entityType, $entity)
    {
        self::log('reject', $entityType, $entity->id, null, ['status' => 'rejected']);
    }

    public static function logExport($entityType, $filters = null)
    {
        self::log('export', $entityType, null, null, ['filters' => $filters]);
    }
}