<?php

namespace App;

trait RecordsActivity {
    protected static $phases = ['created', 'updated'];

    public static function booted() {
        foreach (static::$phases as $phase) {
            static::$phase(function ($model) {
                $model->activities()->create([]);
            });
        }
    }
}