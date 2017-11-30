select
  organization is null,
  institution_id is null,
  klr_tow,
  st.name,
  count(pid)
from publications p 
  left join ToW t on t.tow = p.klr_tow 
  left join super_types st on st.id = t.super_type_id 
group by organization is null, institution_id is null, klr_tow
order by st.name;