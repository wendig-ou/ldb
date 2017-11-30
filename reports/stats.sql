SELECT
  p.fdate AS year,
  count(DISTINCT p.pid) AS publications,
  count(a.laid) as authors,
  sum(
    /*amount of ';' within the field*/
    LENGTH(p.authors) - LENGTH(REPLACE(p.authors, ';', '')) + 1 -
    /*is the last character a ';'?*/
    (RIGHT(p.authors, 1) = ';')
  ) AS legacy_authors,
  sum(a.igb) AS igb
FROM
  publications p
  LEFT JOIN igb_ldb_lom_authors a ON a.publication_id = p.pid
GROUP BY p.fdate
/*HAVING p.fdate >= 2014*/
ORDER BY year DESC