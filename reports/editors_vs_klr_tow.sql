select
  editors is null or editors = '',
  klr_tow,
  st.name,
  count(pid) c
from publications p
  left join ToW t on t.tow = p.klr_tow
  left join super_types st on st.id = t.super_type_id
group by editors is null or editors = '', klr_tow
order by st.name;