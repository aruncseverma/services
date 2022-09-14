<?php
/**
 * usable trait class for models who has relationship with *_descriptions eloquent models
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

trait HasDescriptions
{
    /**
     * get the description based on given code
     *
     * @param  string $code
     * @param bool $useFallback
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getDescription(string $code, bool $useFallback = true) : Model
    {
        if ($useFallback) {
            $fallbackCode = config('app.fallback_locale');
        }

        if ($this->descriptions) {
            $fallbackDescription = '';
            foreach ($this->descriptions as $description) {
                if ($description->getAttribute('lang_code') === $code) {
                    return $description;
                }
                if (!empty($fallbackCode) && $description->getAttribute('lang_code') == $fallbackCode) {
                    $fallbackDescription = $description;
                }
            }
            if (!empty($fallbackDescription)) {
                return $fallbackDescription;
            }
        }

        // check from database
        $codes = [$code];
        if (!empty($fallbackCode)) {
            $codes[] = $fallbackCode;
        }
        $description = $this->descriptions()
            ->whereIN('lang_code', $codes)
            ->orderByRaw('FIELD(lang_code, "'.implode('", "', $codes).'")')
            ->first();

        return ($description) ?: $this->descriptions()->getModel();
    }

    /**
     * define descriptions relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    abstract public function descriptions() : Relations\HasMany;
}
