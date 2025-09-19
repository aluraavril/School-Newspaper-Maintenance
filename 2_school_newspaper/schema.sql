CREATE TABLE school_publication_users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
);

CREATE TABLE articles (
    article_id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT(11) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    image_path VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (article_id),
    KEY (author_id),
    CONSTRAINT fk_articles_author FOREIGN KEY (author_id) 
        REFERENCES school_publication_users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE article_permissions (
    permission_id INT(11) NOT NULL AUTO_INCREMENT,
    article_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (permission_id),
    KEY (article_id),
    KEY (user_id),
    CONSTRAINT fk_permissions_article FOREIGN KEY (article_id) 
        REFERENCES articles(article_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_permissions_user FOREIGN KEY (user_id) 
        REFERENCES school_publication_users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE edit_requests (
    request_id INT(11) NOT NULL AUTO_INCREMENT,
    article_id INT(11) NOT NULL,
    requester_id INT(11) NOT NULL,
    author_id INT(11) NOT NULL,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (request_id),
    KEY (article_id),
    KEY (requester_id),
    KEY (author_id),
    CONSTRAINT fk_requests_article FOREIGN KEY (article_id) 
        REFERENCES articles(article_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_requests_requester FOREIGN KEY (requester_id) 
        REFERENCES school_publication_users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_requests_author FOREIGN KEY (author_id) 
        REFERENCES school_publication_users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- addl

CREATE TABLE notifications (
    notification_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id),
    KEY (user_id),
    CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) 
        REFERENCES school_publication_users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
