drop table if exists users;
drop table if exists queue;

create table users
(
    id        bigint auto_increment,
    username  varchar(255)         not null,
    email     varchar(255)         not null,
    validts   bigint     default 0 not null,
    confirmed tinyint(1) default 0 not null,
    checked   tinyint(1) default 0 not null,
    valid     tinyint(1) default 0 not null,
    constraint id primary key (id),
    constraint users_unique unique (username)
);

create index users_validts_checked_confirmed_idx
    on users (validts, checked, confirmed);

create index users_validts_valid_idx
    on users (validts, valid);

create table queue
(
    id      bigint auto_increment,
    user_id bigint not null,
    job_id  bigint not null,
    status  tinyint(1) default 0 not null,
    constraint id primary key (id),
    constraint user_id_job_id_unique unique (user_id, job_id)
);

create index queue_job_id_status_idx
    on queue (job_id, status);

