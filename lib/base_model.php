<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        }

        return $errors;
    }

    public function validate_string_length($string, $length) {
//        $errors = array();
        if (strlen($string) < $length) {
            $this->errors[] = 'Vähintään kolme merkkiä nimeen!';
        }

        return $errors;
    }

    public function validate_email($email) {
//        $errors = array();
        if (strpos($email, '@') !== FALSE) {
            $this->errors[] = 'Ät merkin puute vaikeuttaa emailin käyttöä...';
        }
//        TODO: Muuta paremmaksi regex lauseella kun ehdit esim. https://stackoverflow.com/questions/4366730/how-do-i-check-if-a-string-contains-a-specific-word


        return $errors;
    }

}
