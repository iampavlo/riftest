<?php


$sql1 = 'select orderdate, pg_id, top_nameshort, ifnull(sum(tot),0) as tot
from (
SELECT pg_id
, count(o_id) as tot
, date(o_creationdate) as orderdate
,  pg_nameshort as top_nameshort
FROM `productgroups` pg
inner join `products` pr on pr.p_productgroupid = pg_id
inner join `orders` od on od.o_productid = pr.p_id
where pg_supergroupid=pg_id
group by date(o_creationdate), pg_id, pg_nameshort
union all                                                       
SELECT t1.pg_supergroupid as pg_id
, count(o_id)  as tot
, date(o_creationdate) as orderdate
,  t1.pg_nameshort as top_nameshort
FROM
(SELECT mdl.pg_id as mid_id , top.pg_supergroupid, top.pg_nameshort 
FROM `productgroups` mdl
inner join (
			SELECT pg_id, pg_supergroupid, pg_nameshort FROM `productgroups` pg
			where pg_supergroupid=pg_id)top on top.pg_id = mdl.pg_supergroupid
where mdl.pg_id<>mdl.pg_supergroupid
and mdl.pg_id not in (SELECT pg_supergroupid FROM productgroups pg))t1
inner join `products` pr on pr.p_productgroupid = t1.mid_id
inner join `orders` od on od.o_productid = pr.p_id
group by date(o_creationdate), t1.pg_supergroupid, t1.pg_nameshort
union all
SELECT top_supergroupid as pg_id
, count(o_id)  as tot
, date(o_creationdate) as orderdate
,  top_nameshort
FROM
(SELECT lw.pg_id as lw_id
, t1.pg_supergroupid as top_supergroupid
, t1.pg_nameshort as top_nameshort
FROM `productgroups` lw
inner join
(SELECT mdl.pg_id as mid_id , top.pg_supergroupid, top.pg_nameshort 
FROM `productgroups` mdl
inner join (
			SELECT pg_id, pg_supergroupid, pg_nameshort FROM `productgroups` pg
			where pg_supergroupid=pg_id)top on top.pg_id = mdl.pg_supergroupid
where mdl.pg_id<>mdl.pg_supergroupid)t1 on lw.pg_supergroupid = t1.mid_id)t2
inner join `products` pr on pr.p_productgroupid = t2.lw_id
inner join `orders` od on od.o_productid = pr.p_id
group by date(o_creationdate), t2.top_supergroupid, t2.top_nameshort
)t5
group by orderdate, pg_id, top_nameshort';

$sql2 = 'select distinct pg_id, top_nameshort from  ('.$sql1.')t7 order by pg_id';