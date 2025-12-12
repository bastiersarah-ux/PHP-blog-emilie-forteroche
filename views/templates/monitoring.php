<?php

/** 
 * Affichage de la partie admin : tableau de monitoring pour consulter les statistiques.
 */

?>

<h2>Statistiques</h2>
<div class="adminArticle p-1">
    <table>
        <thead>
            <th>Article</th>
            <th>Date de publication</th>
            <th>Nombre de vues</th>
            <th>Nombre de commentaires</th>
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