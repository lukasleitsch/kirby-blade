<?php

// Laravel's e() must win over Kirby's, so this has to run before Composer's autoloader
define('KIRBY_HELPER_E', false);
