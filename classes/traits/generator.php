<?php
// The highly unnecessary trait.
// But as far as functionality goes, this is a good excuse to make one.
trait NameGenerator {
    
    // Just a really tiny hash function that ensures
    // it would be impossible to repeat a name for two
    // different seeds.
    public function getLetters($seed) {
        $letters = '';
        while($seed > 26) {
            $letters .= 'Z';
            $seed -= 26;
        }
        return $letters . chr(64+$seed);
    }
}