SELECT    
h.uname,
a.ptype,
d.tsname,
a.pidentnr,
a.title,
     (
        SELECT             
        group_concat(f.Person ORDER BY e.ord ASC SEPARATOR '; ') 
        FROM igb_ldb_lom_authors e
        JOIN igb_ldb_lom_persons f 
        ON e.lpid = f.lpid WHERE             
        e.pidentnr = a.pidentnr 
    ) AS authors,
  
       (
        SELECT             
        group_concat(f.Person ORDER BY e.ord ASC SEPARATOR '; ') 
        FROM igb_ldb_lom_authors e
        JOIN igb_ldb_lom_persons f 
        ON e.lpid = f.lpid WHERE             
        e.pidentnr = a.pidentnr AND e.igb = 1 
    ) AS IGBauthors,

(
        SELECT COUNT(e.pidentnr)
FROM igb_ldb_lom_authors e
WHERE e.igb = 1 AND e.pidentnr = a.pidentnr
    ) AS IGBcount,
  
  
  (
        SELECT    
    f.Person
        FROM igb_ldb_lom_authors e
        JOIN igb_ldb_lom_persons f 
        ON e.lpid = f.lpid WHERE             
        e.pidentnr = a.pidentnr AND e.igb = 1 AND e.ord = 1
    )   AS IGBFirstauthor,
  
    a.notes,
    b.pname,
  a.impactf,
    a.doi,
    a.klr_tow,
    c.t_desc as typeofwork

from
    publications a
        left join periodicals b on a.pname_id = b.pid
        left join ToW c on a.klr_tow = c.tow
        left join p_types d on a.ptype = d.tid
        left join igb_ldb_institutions g on a.organization = g.iid
    left join passwd h on a.uid = h.uid
where    
    a.fdate <= 2017
    AND (a.end_fdate IS NULL or a.end_fdate = '' OR a.end_fdate >= 2017)
    AND (c.tow = 01.01 or c.tow = 01.02 or c.tow = 01.10)
