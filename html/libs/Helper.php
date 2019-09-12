<?php

//TEST dodanie helpera z metodami statycznymi w celu użycia ich w dowolnym miejscu

class Helper {

    //TEST Metoda oblicza średnią ocen 
    public static function calculateAverageRating($opinie, $productId = null) {

        if (!$opinie) {
            return 'Brak ocen';
        }

        $rates = 0;
        $count = 0;
        foreach ($opinie as $opinia) {
            if (is_object($opinia) && $productId == $opinia->idProduktu) {
                $rates += $opinia->getOcena();
                $count++;
                continue;
            } elseif (!$productId) {
                $rates += $opinia['ocena'];
                $count++;
            }
            continue;
        }

        if ($count == 0) {
            return 'Brak ocen';
        }

        return $rates / $count;
    }

    //TEST Metoda wybiera ostatnie trzy opinie  
    public static function getOpinions($opinie, $productId = null) {

        if (!$opinie) {
            return 'Brak opinii';
        }

        $count = 0;
        $opinions = '';
        foreach ($opinie as $opinia) {
            if ($count == 3) {
                return $opinions;
            } elseif (is_object($opinia) && $productId == $opinia->idProduktu) {
                $opinions .= $opinia->getOpinia() . "<br><br>";
                $count++;
                continue;
            } elseif (!$productId && $opinia['opinia']) {
                $opinions .= $opinia['opinia'] . "<br><br>";
                $count++;
            }
            continue;
        }

        if (empty($opinions)) {
            return 'Brak opinii';
        }
        return $opinions;
    }

}
