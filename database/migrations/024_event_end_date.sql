-- Events: support date ranges (add end date column)
ALTER TABLE events
  ADD COLUMN event_end_date DATE NULL AFTER event_date;
