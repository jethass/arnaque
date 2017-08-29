<!doctype html>
<html lang="fr">
    <meta charset="iso-8859-1">
    <title>Contrôle arnaque</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <body>

        <section class="container">
            <div class="row">
                <ul class="nav nav-pills">
                    <li class="h4 active" role="presentation">
                        <a id="link-report-identical-ip" href="#">IP identique</a>
                    </li>
                    <li class="h4" role="presentation">
                        <a id="link-report-invalid-ip" href="#">IP invalide</a>
                    </li>
                    <li class="h4" role="presentation">
                        <a id="link-report-invalid-content" href="#">Contenu frauduleux</a>
                    </li>
                    <li class="h4" role="presentation">
                        <a id="link-report-identical-mail-type" href="#">Fraude détectée sur mail-type</a>
                    </li>
                </ul>
                <br />
            </div>
            <div id="section-report-identical-ip" style="display:none">
                <p>
                    Pour identifier les contacts par email d'une même IP !! Attention vérifier le texte avant de bloquer
                </p>
                <table id="report-identical-ip" class="table table-striped">
                    <thead>
                        <th width="100">Références</th>
                        <th width="100">Adresses IP</th>
                        <th width="50">Occurence</th>
                        <th width="200">Destinataires</th>
                        <th width="200">Contenu du mail</th>
                        <th width="200">Actions</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">En cours de chargement, veuillez patienter...</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div id="section-report-invalid-ip" style="display:none">
                <p>
                    Pour identifier les annonces multiples déposées sur une IP donnée !!! attention, il faut vérifier si cette IP est "normale" il y a l'IP de Peugeot par exemple qui est ajoutée dans la requête pour la laisser passer !! Plus tard bloquer les IP si fraudeur ou pro pour empêcher de redéposer
                </p>
                <table id="report-invalid-ip" class="table table-striped">
                    <thead>
                        <th>Références</th>
                        <th>Adresses IP</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">En cours de chargement, veuillez patienter...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="section-report-invalid-content">
                <p>
                    Pour identifier le contenu copier/coller demandant expressément de communiquer l'adresse de messagerie de l'acheteur !!! attention vérifier le texte avant de bloquer
                </p>
                <table id="report-invalid-content" class="table table-striped">
                    <thead>
                        <th>Références</th>
                        <th>Adresses IP</th>
                        <th>Occurence</th>
                        <th>Destinataires</th>
                        <th>Contenu du mail</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">En cours de chargement, veuillez patienter...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="section-report-identical-mail-type" style="display:none">
                <p>
                    Fraude détectée sur mail-type toujours identique : trier par nombre de résultats décroissants (les > 10 sont des fraudes certaines)
                </p>
                <table id="report-identical-mail-type" class="table table-striped">
                    <thead>
                        <th>Références</th>
                        <th>Immatriculation</th>
                        <th>Téléphone</th>
                        <th>Occurence</th>
                        <th>Destinataires</th>
                        <th>Contenu du mail</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">En cours de chargement, veuillez patienter...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                    </div>
                    <div class="modal-body" style="color:#5cb85c">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="js/arnaque.js"></script>
        <script>
            $(document).ready(function() {
                ModuleArnaque.load()
            });
        </script>
    </body>
</html>
