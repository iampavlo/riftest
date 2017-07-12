<?php

$sql3=
        'select distinct date(o_creationdate) as orderdate
from orders
order by date(o_creationdate)';
