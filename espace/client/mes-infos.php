

                    <form action="<?= BASE_URL ?>/traitement/modif-info-perso.php" method="post" id="form-update-account">
                        <fieldset>
                            
                            <div class="personal-info">
                                <h3>Vos Coordonnées</h3>
                                <label> </label>

                                <label for="nom">NOM</label>
                                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?? '' ?>" placeholder="Votre nom de famille" >
                                
                                <label for="prenom">PRÉNOM</label>
                                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?? '' ?>" placeholder="Votre prénom" >
                                
                                <label for="email">E-MAIL</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?? '' ?>" placeholder="Votre e-mail" >
                                

                                <label for="tel">TÉLÉPHONE</label>
                                <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user['tel']) ??  '' ?>" placeholder="Votre numéro de téléphone" >

                                <label for="adresse">ADRESSE</label>
                                <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?? '' ?>" placeholder="Votre adresse" >

                                <label for="ville">VILLE</label>
                                <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($user['ville']) ??   '' ?>" placeholder="Votre ville de domiciliation" >

                                <label for="complement-adresse">COMPLÉMENT D'ADRESSE</label>
                                <input type="text" id="complement-adresse" name="complement-adresse" value="<?= htmlspecialchars($user['complement_adresse']) ?? '' ?>" placeholder="Complément d'adresse" >

                                <label for="code-postal">CODE POSTAL</label>
                                <input type="text" id="code-postal" name="code-postal" value="<?= htmlspecialchars($user['code_postal']) ?? '' ?>" placeholder="code postal" >
                            </div>
                        </fieldset>

                            <div class="btn-personal-info">
                                <button type="submit" class="btn-submit-personal-info" name="update-account">Mettre à jour</button>
                            </div>
                    </form>