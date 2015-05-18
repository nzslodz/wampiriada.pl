CREATE VIEW actions AS SELECT
                action_days.created_at as day, action_days.start as start, action_days.end as end, action_days.marrow as marrow, 
                places.name as place, schools.short_name as school_short, schools.name as school, places.address as address,
				places.lat as lat, places.lng as lng, editions.`number` as `number`
            FROM action_days 
                JOIN places on action_days.place_id = places.id 
                JOIN schools on places.school_id = schools.id 
                JOIN editions on action_days.edition_id = editions.id;
