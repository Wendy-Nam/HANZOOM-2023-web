
CREATE DATABASE IF NOT EXISTS kau;

USE kau;



CREATE TABLE event (
    event_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NULL,
    dtype VARCHAR(255) NOT NULL,
    text VARCHAR(255) NULL,
    place VARCHAR(255) NULL,
    duration VARCHAR(255) NULL,
    url VARCHAR(255) NULL,
    detail VARCHAR(255) NULL,
    detail2 TEXT NULL,
    status INT NULL
)CHARACTER SET utf8;

CREATE TABLE information (
    information_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NULL,
    dtype VARCHAR(255) NOT NULL,
    text VARCHAR(255) NULL,
    place VARCHAR(255) NULL,
    duration VARCHAR(255) NULL,
    url VARCHAR(255) NULL,
    detail VARCHAR(255) NULL,
)CHARACTER SET utf8;

-- user Table Create SQL
CREATE TABLE user (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `id` VARCHAR(40),
    `password` VARCHAR(40),
    `phonenumber` VARCHAR(11) NULL, 
    `sns_address` VARCHAR(45) NULL, 
    `user_picture` VARCHAR(45) NULL, 
    `stay_duration` DATE NULL, 
    `stay_purpose` VARCHAR(50) NULL, 
    `name` VARCHAR(50) NULL, 
    `email` VARCHAR(50) NULL, 
    `sex` CHAR(1) NULL, 
    `is_manager` TINYINT NULL
)CHARACTER SET utf8;

-- post Table Create SQL
CREATE TABLE post (
    `id` INT AUTO_INCREMENT PRIMARY KEY, 
    `text` VARCHAR(500) NULL,
    `title` VARCHAR(144) NOT NULL, 
    `author_id` INT NOT NULL, 
    `password` VARCHAR(40),
    `reg_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `comments_enabled` TINYINT(1) NOT NULL, 
    `update_date` DATETIME NULL, 
    `delete_date` DATETIME NULL
) CHARACTER SET utf8;

-- post_category Table Create SQL
CREATE TABLE post_category (
    `category_id` INT AUTO_INCREMENT PRIMARY KEY, 
    `post_id` INT NOT NULL, 
    `name` VARCHAR(50) NULL
)CHARACTER SET utf8;

-- recommended Table Create SQL
CREATE TABLE recommended (
    `count_like` INT NULL, 
    `liked_post_id` INT PRIMARY KEY
)CHARACTER SET utf8;

-- comment Table Create SQL
CREATE TABLE comment (
    `id` INT AUTO_INCREMENT PRIMARY KEY, 
    `post_id` INT NOT NULL, 
    `is_reply_to_id` INT NOT NULL, 
    `comment_content` TEXT NOT NULL, 
    `user_id` INT NULL, 
    `comment_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
)CHARACTER SET utf8;

-- post_tag Table Create SQL
CREATE TABLE post_tag (
    `id` INT AUTO_INCREMENT PRIMARY KEY, 
    `post_id` INT NOT NULL, 
    `tag` VARCHAR(45) NOT NULL
)CHARACTER SET utf8;

-- file Table Create SQL
CREATE TABLE file (
    `file_id` INT AUTO_INCREMENT PRIMARY KEY, 
    `post_id` INT NOT NULL, 
    `file_name` VARCHAR(50) NOT NULL, 
    `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)CHARACTER SET utf8;
-- admin_post Table Create SQL
CREATE TABLE admin_post (
    `id` INT AUTO_INCREMENT PRIMARY KEY
)CHARACTER SET utf8;

-- 좋아요 테이블 생성 SQL (참조 무결성 무시)
CREATE TABLE post_like (
    `user_id` INT NOT NULL, 
    `post_id` INT NOT NULL, 
    PRIMARY KEY (user_id, post_id)
)CHARACTER SET utf8;

-- 외래 키 제약 조건 추가
ALTER TABLE post
ADD FOREIGN KEY (author_id) REFERENCES user (user_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE post_category
ADD FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE recommended
ADD FOREIGN KEY (liked_post_id) REFERENCES post (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE comment
ADD FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE post_tag
ADD FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE file
ADD FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE RESTRICT ON UPDATE RESTRICT;