<?php

require_once 'Database.php';

class ArticlePermission extends Database
{

    public function grantPermission($article_id, $user_id)
    {
        $sql = "INSERT INTO article_permissions (article_id, user_id) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $user_id]);
    }

    public function hasPermission($article_id, $user_id)
    {
        $sql = "SELECT COUNT(*) as permission_count FROM article_permissions WHERE article_id = ? AND user_id = ?";
        $result = $this->executeQuerySingle($sql, [$article_id, $user_id]);
        return $result['permission_count'] > 0;
    }

    public function getSharedArticles($user_id)
    {
        $sql = "SELECT * FROM articles 
                JOIN article_permissions ON articles.article_id = article_permissions.article_id 
                JOIN school_publication_users ON articles.author_id = school_publication_users.user_id
                WHERE article_permissions.user_id = ?";
        return $this->executeQuery($sql, [$user_id]);
    }
}
