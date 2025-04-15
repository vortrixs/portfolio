#!/bin/bash

# Check if the appropriate number of arguments is provided
if [ "$#" -ne 2 ]; then
  echo "Usage: $0 <sql_directory> <database_file>"
  exit 1
fi

# Assign command-line arguments to variables
SQL_DIR="$1"
DB_FILE="$2"

# Check if the provided directory exists
if [ ! -d "$SQL_DIR" ]; then
  echo "Error: Directory $SQL_DIR does not exist."
  exit 1
fi

# Check if the database file exists, if not create it
if [ ! -f "$DB_FILE" ]; then
  echo "Creating SQLite database: $DB_FILE"
  sqlite3 "$DB_FILE" "VACUUM;"
fi

# Find and sort the .sql files by modification date (oldest first)
sorted_files=$(find "$SQL_DIR" -type f -name "*.sql" -print0 | xargs -0 ls -tr)

# Loop through the sorted files
for sql_file in $sorted_files; do
  echo "Running SQL file: $sql_file"
  # Execute the SQL file using sqlite3 and capture any error message
  error_message=$(sqlite3 "$DB_FILE" < "$sql_file" 2>&1)

  # Check if the command succeeded
  if [ $? -eq 0 ]; then
    echo "Successfully executed $sql_file"
  else
    echo "Error executing $sql_file"
    echo "SQLite error message: $error_message"
  fi
done

echo "All SQL files have been processed."