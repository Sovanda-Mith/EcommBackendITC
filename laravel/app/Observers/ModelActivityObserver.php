<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

use function GuzzleHttp\json_encode;

class ModelActivityObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'created',
            'changes' => json_encode($model->toArray()),
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'updated',
            'changes' => json_encode([
                'old' => $model->getOriginal(),
                'new' => $model->getChanges(),
            ]),
        ]);
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'deleted',
            'changes' => json_encode($model->toArray()),
        ]);
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
