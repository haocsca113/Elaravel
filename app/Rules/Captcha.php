<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha;

class Captcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
    }

    public function passes($attribute, $value)
    {
        if (!$value) {
            return false;
        }

        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $response = $recaptcha->verify($value, request()->ip());

        // Debug lỗi
        if (!$response->isSuccess()) {
            dd([
                'success' => false,
                'error_codes' => $response->getErrorCodes(),
                'value' => $value, 
                'ip' => request()->ip(),
            ]);
        }

        return $response->isSuccess();
    }

    public function message()
    {
        return 'Xác nhận reCAPTCHA không hợp lệ. Vui lòng thử lại.';
    }
}
