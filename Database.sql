CREATE TABLE users (
    user_id     INT (32) NOT NULL AUTO_INCREMENT,
    user_name   VARCHAR (50) NOT NULL,
    user_pass   VARCHAR (255) NOT NULL,
    user_email  VARCHAR (255),
    user_date   DATETIME NOT NULL,
    user_level  INT (8) NOT NULL,
    user_posts  INT (32) DEFAULT 0,
    user_topics INT (32) DEFAULT 0,
    user_image  BLOB,
    UNIQUE      INDEX user_name_unique (user_name),
    PRIMARY     KEY (user_id)
)   ENGINE=INNODB;

CREATE TABLE categories (
    cat_id          INT(32) NOT NULL AUTO_INCREMENT,
    cat_name        VARCHAR (255) NOT NULL,
    cat_description VARCHAR (255) NOT NULL,
    UNIQUE          INDEX cat_name_unique (cat_name),
    PRIMARY         KEY (cat_id)
) ENGINE=INNODB;

CREATE TABLE topics (
    topic_id        INT(32) NOT NULL AUTO_INCREMENT,
    topic_subject   VARCHAR(255) NOT NULL,
    topic_date      DATETIME NOT NULL,
    topic_cat       INT(32) NOT NULL,
    topic_by        INT(32) NOT NULL,
    topic_count     INT (32),
    PRIMARY         KEY (topic_id)
) ENGINE=INNODB;

CREATE TABLE posts (
    post_id         INT(32) NOT NULL AUTO_INCREMENT,
    post_content    TEXT NOT NULL,
    post_date       DATETIME NOT NULL,
    post_topic      INT(32) NOT NULL,
    post_by         INT(32) NOT NULL,
    PRIMARY         KEY (post_id)
) ENGINE=INNODB;

CREATE TABLE password_recovery(
    id              INT(32) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR (255),
    token           VARCHAR (255) UNIQUE
) ENGINE=INNODB;

CREATE TABLE search(
                       id              INT(32) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       value           VARCHAR (255) NOT NULL,
                       date            DATETIME NOT NULL,
                       search_by       INT(32) NOT NULL
) ENGINE=INNODB;

CREATE TABLE image (
                        id              INT (32) AUTO_INCREMENT NOT NULL PRIMARY KEY,
                        image           VARCHAR(255) DEFAULT 'avatar.png',
                        image_for       INT (32)
)ENGINE = INNODB;

ALTER TABLE image ADD FOREIGN KEY (image_for) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- Link image_for to user_id
ALTER TABLE topics ADD FOREIGN KEY(topic_cat) REFERENCES categories(cat_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- Set topic_cat as a foreign key and references it to categories(cat_id), update them automatically and requires the
-- category to be fully empty before deletion (no topics)
ALTER TABLE topics ADD FOREIGN KEY(topic_by) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- Links the topics according to which user wrote them
ALTER TABLE posts ADD FOREIGN KEY(post_topic) REFERENCES topics(topic_id) ON DELETE CASCADE ON UPDATE CASCADE;
-- Link posts to topics
ALTER TABLE posts ADD FOREIGN KEY(post_by) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- Link posts to users
ALTER TABLE search ADD FOREIGN KEY(search_by) REFERENCES users(user_id);
-- Link search value to user who did that search

