<?php

/** 
 * Affichage de la partie admin : tableau de monitoring pour consulter les statistiques.
 */



function getActiveClass(string $sort, string $order): string
{
    $currentSort = $_GET['sort'] ?? 'date';
    $currentOrder = $_GET['order'] ?? 'DESC';
    return $currentSort == $sort && $currentOrder == $order ? 'active' : '';
}

?>

<h2>Statistiques</h2>
<div class="adminArticle p-1">
    <table>
        <thead>
            <th>
                <div class="column-header">
                    Article
                    <span class="sort-icons">
                        <a href="index.php?action=monitoringArticle&sort=article&order=ASC"
                            class="<?= getActiveClass('article', 'ASC') ?>">▲</a>
                        <a href="index.php?action=monitoringArticle&sort=article&order=DESC"
                            class="<?= getActiveClass('article', 'DESC') ?>">▼</a>
                    </span>
                </div>
            </th>
            <th>
                <div class="column-header">
                    Date de publication
                    <span class="sort-icons">
                        <a href="index.php?action=monitoringArticle&sort=date&order=ASC"
                            class="<?= getActiveClass('date', 'ASC') ?>">▲</a>
                        <a href="index.php?action=monitoringArticle&sort=date&order=DESC"
                            class="<?= getActiveClass('date', 'DESC') ?>">▼</a>
                    </span>
                </div>
            </th>
            <th>
                <div class="column-header">
                    Nombre de vues
                    <span class="sort-icons">
                        <a href="index.php?action=monitoringArticle&sort=views&order=ASC"
                            class="<?= getActiveClass('views', 'ASC') ?>">▲</a>
                        <a href="index.php?action=monitoringArticle&sort=views&order=DESC"
                            class="<?= getActiveClass('views', 'DESC') ?>">▼</a>
                    </span>

                </div>
            </th>
            <th>
                <div class="column-header">
                    Nombre de commentaires
                    <span class="sort-icons">
                        <a href="index.php?action=monitoringArticle&sort=comments&order=ASC"
                            class="<?= getActiveClass('comments', 'ASC') ?>">▲</a>
                        <a href="index.php?action=monitoringArticle&sort=comments&order=DESC"
                            class="<?= getActiveClass('comments', 'DESC') ?>">▼</a>
                    </span>
                </div>
            </th>
        </thead>
        <tbody>
            <?php foreach ($statistics as $data) { ?>
                <tr>
                    <td><?= $data->getTitle() ?></td>
                    <td><?= Utils::convertDateToFrenchFormat($data->getDateCreation()) ?></td>
                    <td><?= $data->getViews() ?></td>
                    <td><?= $data->getComments() ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>