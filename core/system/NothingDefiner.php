<?php

define('NAME_VALIDATION', "text|not_special|min:3|max:30");
define('EMAIL_VALIDATION', "email");
define('PASSWORD_VALIDATION', "min:6|max:16|special");
define('ROLE_VALIDATION', "number|min:1|max:1");