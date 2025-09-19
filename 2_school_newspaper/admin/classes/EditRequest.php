<?php

require_once 'Database.php';

class EditRequest extends Database
{

    public function createRequest($article_id, $requester_id, $author_id)
    {
        $sql = "INSERT INTO edit_requests (article_id, requester_id, author_id) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $requester_id, $author_id]);
    }

    public function getRequestsByAuthor($author_id)
    {
        $sql = "SELECT * FROM edit_requests 
                JOIN articles ON edit_requests.article_id = articles.article_id 
                JOIN school_publication_users ON edit_requests.requester_id = school_publication_users.user_id
                WHERE edit_requests.author_id = ? AND status = 'pending'";
        return $this->executeQuery($sql, [$author_id]);
    }

    public function updateRequestStatus($request_id, $status)
    {
        $sql = "UPDATE edit_requests SET status = ? WHERE request_id = ?";
        return $this->executeNonQuery($sql, [$status, $request_id]);
    }

    public function getRequestById($request_id)
    {
        $sql = "SELECT * FROM edit_requests WHERE request_id = ?";
        return $this->executeQuerySingle($sql, [$request_id]);
    }
}
