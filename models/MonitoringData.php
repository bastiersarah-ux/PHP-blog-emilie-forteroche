<?php

/**
 * Modèle de monitoring, représente les données de suivi d'un article
 * id, title, date_creation, comments, views
 */
class MonitoringData extends AbstractEntity
{
    private string $title;
    private ?DateTime $dateCreation = null;
    private int $comments = 0;
    private int $views = 0;

    /**
     * Définit le titre.
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Récupère le titre.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($dateCreation)) {
            $dateCreation = DateTime::createFromFormat($format, $dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    /**
     * Récupère la date de création.
     *
     * @return DateTime|null
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Définit le nombre de commentaires.
     *
     * @param int $comments
     * @return void
     */
    public function setComments(int $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * Récupère le nombre de commentaires.
     *
     * @return int
     */
    public function getComments(): int
    {
        return $this->comments;
    }

    /**
     * Définit le nombre de vues.
     *
     * @param int $views
     * @return void
     */
    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    /**
     * Récupère le nombre de vues.
     *
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }
}
