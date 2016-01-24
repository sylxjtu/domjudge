<?php

require('init.php');
header('content-type: application/json');

$problems = $DB->q("TABLE SELECT langid AS id, name,
                    CONCAT(name, ' (', langid, ')') AS search FROM language
                    WHERE (name LIKE %c OR langid LIKE %c)",
                   $_GET['q'], $_GET['q']);

echo json_encode($problems);
