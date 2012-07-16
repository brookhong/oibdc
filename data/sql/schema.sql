CREATE TABLE note (id BIGINT AUTO_INCREMENT, title VARCHAR(255), content TEXT NOT NULL, tag VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;