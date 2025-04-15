create table if not exists cv (
    id serial primary key,
    position text,
    company text,
    employmentType text,
    length text,
    tags text[],
    description text
);