select 
  p.klr_tow `type of work`,
  t.t_desc `type name`,
  count(p.pid) `# publications`
from publications p
left join ToW t on p.klr_tow = t.tow
group by p.klr_tow
order by `# publications` desc;
