<?php

namespace SlapChop;

class Vince
{

    public static function sellIt()
    {
        $pitches = [
            'You\'re going to be in a great mood all day, because you\'re going be slapping your troubles away with the SlapChop',
            'You’re going to love my nuts',
            'It\'s easy, you just got one hand, and chop.',
            'Look at this you’re going to have an exciting life now.',
            'So easy, one finger, if I can do it with one finger you guys can do it with your whole hand.',
            'Alright life\'s hard enough as it is. You don\'t wanna cry anymore.'
        ];

        return $pitches[rand(0, 5)];
    }
}
