select 
  p.fdate `year of publication`,
  count(p.pid) `# publications`
from publications p
group by `year of publication`
order by `# publications` desc;
