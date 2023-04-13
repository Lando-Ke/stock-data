<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DomainIsActiveRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $domain = explode("@",$value)[1];
        if(!$this->pingDomain($domain)) {
            $fail("The domain {$domain} is not active.Please enter an active email address.");
        }
    }

    protected function pingDomain($domain)
    {
        if(checkdnsrr($domain,"MX")) {
            return true;
        } else {
            return false;
        }
    }
}
