<?php

const abs_url_base		 = 'https://api.scripture.api.bible/v1/bibles';
const abs_url_base_v2   = 'https://rest.api.bible/v1/bibles';

function ABS_URL($key) {
    if (strlen($key) == 21) {
        return abs_url_base_v2;
    }
    return abs_url_base;
}
