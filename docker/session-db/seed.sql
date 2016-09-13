USE session;

## Creation + Indexes
CREATE TABLE sessions
(
  session_id VARCHAR(255) PRIMARY KEY NOT NULL,
  session_data TEXT,
  last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);