<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $primary_color
 * @property string $secondary_color
 * @property string $logo_path
 * @property string $watermark_path
 * @property float $watermark_opacity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereSecondaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereWatermarkOpacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereWatermarkPath($value)
 * @mixin \Eloquent
 */
class AppearanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tenant_id',
        'primary_color',
        'secondary_color',
        'logo_path',
        'watermark_path',
        'watermark_opacity',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'primary_color' => '#64b5f6',
        'secondary_color' => '#b0bec5',
        'logo_path' => 'images/zonda/landscape_logo.png',
        'watermark_path' => 'images/zonda/watermark.png',
        'watermark_opacity' => 0.1
    ];
}
