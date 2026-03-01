-- Add 4th hero pillar (Witness) to existing hero_config with 3 pillars
UPDATE content_sections
SET extra_data = JSON_SET(COALESCE(extra_data, CAST('{}' AS JSON)), '$.pillars', CAST('["Welcome","Worship","Word","Witness"]' AS JSON))
WHERE section_key = 'hero_config'
  AND JSON_LENGTH(COALESCE(JSON_EXTRACT(extra_data, '$.pillars'), CAST('[]' AS JSON))) = 3;
