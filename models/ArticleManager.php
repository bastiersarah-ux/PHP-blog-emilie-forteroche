<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Enregistre la vue d'un article.
     * On utilise un INSERT avec ON DUPLICATE KEY UPDATE pour éviter de compter deux fois la même IP pour le même article.
     *
     * @param integer $articleId
     * @param string $ipAddress
     * @return boolean
     */
    public function addView(int $articleId, string $ipAddress): void
    {
        $sql = "INSERT INTO article_view (id_article, ip_address)
            VALUES (:id_article, :ip_address)
            ON DUPLICATE KEY UPDATE id_article = :id_article"; // Evite doublons (UNIQUE_KEY)

        $this->db->query($sql, [
            'id_article' => $articleId,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Récupère le nombre de vue d'un article.
     *
     * @param integer $articleId
     * @return integer
     */
    public function getViews(int $articleId): int
    {
        $sql = "SELECT COUNT(*) AS total_views
            FROM article_view
            WHERE id_article = :id_article";

        $stmt = $this->db->query($sql, [':id_article' => $articleId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Récupère et tri les données du tableau de monitoring
     * $sort = colonne par défaut pour trier (la date)
     * $order = sens de tri par défaut (descendant)
     *
     * @param string $sort
     * @param string $order
     * @return array : un tableau d'objets MonitoringData.
     */
    public function getMonitoringData($sort = 'date_creation', $order = 'DESC'): array
    {
        $allowedSort = ['title', 'views', 'comments', 'date_creation']; // liste des colonnes autorisées pour le tri (sécurité contre l’injection SQL).
        if (!in_array($sort, $allowedSort)) {
            $sort = 'date_creation';
        } // Si $sort n’est pas dans la liste, on retombe sur date.
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';  // Normalisation de l’ordre de tri (ASC / DESC) : mesure de sécurité.
        $sql = "SELECT a.id, a.title, a.date_creation,
                (SELECT COUNT(1) FROM comment c WHERE c.id_article = a.id) AS comments,
                (SELECT COUNT(1) FROM article_view av WHERE av.id_article = a.id) AS views
            FROM article a
            ORDER BY $sort $order";

        $result = $this->db->query($sql);
        $data = [];

        while ($line = $result->fetch()) {
            $data[] = new MonitoringData($line);
        }

        return $data;
    }
}
