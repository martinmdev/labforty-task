<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';

    protected $fillable = [
        'timestamp',
        'names',
        'ucn',
        'description',
        'notification_type_id',
    ];

    protected $with = ['notificationType'];

    public static function getInsertValidationRules()
    {
        $rules = self::getCommonValidationRules();

        return $rules;
    }

    public static function getIdValidationRules()
    {
        return [
            'id' => 'required|exists:appointment',
        ];
    }

    protected static function getCommonValidationRules()
    {
        return [
            'timestamp' => 'required|date',
            'names' => 'required|min:2|max:100',
            'ucn' => 'required|min_digits:10|max_digits:10|numeric',
            'description' => 'max:1000',
            'notification_type_id' => 'required|exists:notification_type,id',
        ];
    }

    public static function getUpdateValidationRules()
    {
        $rules = array_merge(
            self::getIdValidationRules(),
            self::getCommonValidationRules()
        );

        return $rules;
    }

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }
}
